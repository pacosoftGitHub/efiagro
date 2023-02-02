angular.module('FondoRotatorio_Creditos_PayDialogCtrl', [])
.controller('FondoRotatorio_Creditos_PayDialogCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', '$mdToast', '$http', 'CredSel', 'Parent', 'CreditoSrv',
	function($scope, $rootScope, $http, $injector, $mdDialog, $mdToast, $http, CredSel, Parent, CreditoSrv) {

		var Ctrl = $scope;
		Ctrl.Parent = Parent;
		
		Ctrl.Cancel = function(){ $mdDialog.cancel(); }

		//Ctrl.ValorSaldo = Saldo.pendiente + Saldo.mora;
		Ctrl.Hoy = moment().toDate()

		Ctrl.Pago = {
			Fecha: angular.copy(Ctrl.Hoy),
			Valor: angular.copy(CredSel.total_pendiente),
			Medio: "Efectivo",
			NoConsignacion: null,
			SobranteOp: 'PagCuotas',
			AbonadoCapital: 0,
			Devolver: 0,
			Num_Pago_Elim: null,
		}

		//Colores
		Ctrl.Colors = {
	        'Pendiente' 	   : ['#a2a2a2'],
	        'Pagado'    	   : ['#00695c'],
	        'Pendiente Pago Parcial'   : ['#008E7D'],
	        'Mora'      	   : ['#ce0202'],
	        'Mora Pago Parcial': ['#D32F2F'],
	        'Anulado'		   : ['#a2a2a2'],
	    };

	    //Opciones con el sobrante
	    Ctrl.SobranteOps = {
	    	'PagCuotas' : 'Pago de Cuotas',
	    	'PagCapital' : 'Abonar a Capital',
	    };

	    Ctrl.Pagos = [];
	    Ctrl.CredSel = null;

		Ctrl.$watchGroup(['Pago.Fecha','Pago.Valor','Pago.SobranteOp'], function(){
			
			Ctrl.Pagos = [];
			Ctrl.CredSel = angular.copy(CredSel);
			Ctrl.Amortable = null;
			Ctrl.AmortableRes = null;
			Ctrl.Cuota = null;

			var c = Ctrl.CredSel;
			var p = Ctrl.Pago;

			//Calcular las moras de acuerdo a la fecha
			var FechaPago = moment(p.Fecha);
			var Disponible = angular.copy(p.Valor);
			var PendienteMora = 0;
			p.Devolver = 0;
			p.AbonadoCapital = 0;
			p.Num_Pago_Elim = null;

			angular.forEach(c.saldos, function(s){
				//console.log(s);

				s.dias_mora = FechaPago.diff(s.date, 'days');

				if(s.dias_mora < 1 && s.estado == 'Mora'){ //Cambiar a estado pendiente
					s.due = false;
					s.estado = 'Pendiente';
				}else if(s.dias_mora >= 0 && s.estado.substr(0,9) == 'Pendiente'){
					s.due = true;
					s.estado = 'Mora';
				}

				if(!s.due || s.pendiente == 0){
					s.dias_mora = null;
					s.mora = null;
				}else{

					//Calcular interés de mora
					var Interes = null;

						 if(s.dias_mora <= 30)                      { Interes = Parent.Vars?.CREDITO_MORA_MENOS_30 || 0; }
					else if(s.dias_mora >= 31 && s.dias_mora <=  60){ Interes = Parent.Vars?.CREDITO_MORA_31_60    || 0; }
					else if(s.dias_mora >= 61 && s.dias_mora <=  90){ Interes = Parent.Vars?.CREDITO_MORA_61_90    || 0; }
					else if(s.dias_mora >= 91 && s.dias_mora <= 120){ Interes = Parent.Vars?.CREDITO_MORA_91_120   || 0; }
					            		 else if(s.dias_mora >= 121){ Interes = Parent.Vars?.CREDITO_MORA_MAS_120  || 0; }

					Interes = Interes / 100;
					//console.log(Parent.Vars.CREDITO_MORA_MENOS_30, s, Interes);

					var ValMora = Math.ceil( s.pendiente * Interes );
					s.mora = ValMora - s.abonadomora;
	    			
	    			s.mora = s.mora < 0 ? 0 : s.mora;
	    			PendienteMora = PendienteMora + s.mora;
				}

				//Fin del primer foreach
			});

			//Ahora a gastar ese disponible pagando moras
			if(PendienteMora > 0){
				angular.forEach(c.saldos, function(s){
					if(s.mora > 0  && Disponible > 0){
						if(s.mora > Disponible){ //alcanza para pago parcial
							Ctrl.Pagos.push({ credito_id: CredSel.id, saldo_id: s.id, Tipo: 'Parcial', Paga: 'Mora', Valor: Disponible, NoCuota: s.num_pago });
							s.mora = s.mora - Disponible; 
							Disponible = 0;
						}else{ //alcanza para pagar la mora
							Ctrl.Pagos.push({ credito_id: CredSel.id, saldo_id: s.id, Tipo: 'Total', Paga: 'Mora', Valor: s.mora, NoCuota: s.num_pago });
							Disponible = Disponible - s.mora;
							s.mora = 0;
						}
					}
				});
			}

			//Ahora a pagar pendietes
			angular.forEach(c.saldos, function(s){
				if(s.due && s.pendiente > 0 && Disponible > 0){
					if(s.pendiente > Disponible){ //alcanza para pago parcial
						Ctrl.Pagos.push({ credito_id: CredSel.id, saldo_id: s.id, Tipo: 'Parcial', Paga: 'Cuota', Valor: Disponible, NoCuota: s.num_pago });
						s.pendiente = s.pendiente - Disponible; 
						Disponible = 0;
					}else{ //alcanza para pagar la pendiente
						Ctrl.Pagos.push({ credito_id: CredSel.id, saldo_id: s.id, Tipo: 'Total', Paga: 'Cuota', Valor: s.pendiente, NoCuota: s.num_pago });
						Disponible = Disponible - s.pendiente;
						s.pendiente = 0;
					}
				}
			});

			//Si aun queda dinero recalcular crédito definir q hacer con el sobrante
			if(Disponible > 0){

				if(p.SobranteOp == 'Return'){

					var Deuda = 0;
					angular.forEach(c.saldos, function(s, k){
						if(s.estado.substr(0,9) == 'Pendiente'){
							Deuda = Deuda + s.pendiente;
						}
					});
					Ctrl.Deuda = Deuda;

				}else if(p.SobranteOp == 'PagCuotas'){
					var Deuda = 0;
					angular.forEach(c.saldos, function(s, k){
						if(s.estado.substr(0,9) == 'Pendiente' && Disponible > 0){
							
							if(s.pendiente > Disponible){ //alcanza para pago parcial
								Ctrl.Pagos.push({ credito_id: CredSel.id, saldo_id: s.id, Tipo: 'Parcial', Paga: 'Cuota', Valor: Disponible, NoCuota: s.num_pago });
								s.pendiente = s.pendiente - Disponible; 
								s.estado = 'Pendiente Pago Parcial';
								Disponible = 0;
								Deuda = Deuda + s.pendiente;
							}else{ //alcanza para pagar la pendiente
								Ctrl.Pagos.push({ credito_id: CredSel.id, saldo_id: s.id, Tipo: 'Total', Paga: 'Cuota', Valor: s.pendiente, NoCuota: s.num_pago });
								Disponible = Disponible - s.pendiente;
								s.estado = 'Pagado';
								s.pendiente = 0;
							}

						}
					});
					Ctrl.Deuda = Deuda;

				}else if(p.SobranteOp == 'PagCapital'){
					
					var PendienteIndex = null;
					angular.forEach(c.saldos, function(s, k){
						if(s.estado == 'Pendiente'){
							if(PendienteIndex == null) PendienteIndex = k;
							s.estado = 'Anulado';
						}
					});

					if(PendienteIndex !== null){
						var Deuda = parseInt(c.saldos[PendienteIndex].deuda) + parseInt(c.saldos[PendienteIndex].capital);
						var Num_Pago = parseInt(c.saldos[PendienteIndex].num_pago);
						var CuotasRest = c.saldos.length - Num_Pago + 1;

						p.Num_Pago_Elim = Num_Pago;

						if(Disponible < Deuda){ //Pago parcial de la deuda
							Ctrl.Pagos.push({ credito_id: CredSel.id, Tipo: 'Parcial', Paga: 'Capital', Valor: Disponible});
							Deuda = Deuda - Disponible;
							p.AbonadoCapital = Disponible;
							Disponible = 0;
						}else{ //Pago total de la deuda
							Ctrl.Pagos.push({ credito_id: CredSel.id, Tipo: 'Total', Paga: 'Capital', Valor: Deuda});
							Disponible = Disponible - Deuda;
							p.AbonadoCapital = Deuda;
							Deuda = 0;
						}

						if(Deuda > 0){ //Recalcular deuda

							console.log('Recalcular Deuda', Deuda, c, c.saldos[PendienteIndex]);

							var Cuotas = CreditoSrv.CalcCuotas(Deuda, (c.interes/100), CreditoSrv.ScalesRef[c.pagos], CuotasRest, 0, p.Fecha, Num_Pago);

							for (var i = PendienteIndex; i < c.saldos.length; i++) {
								Cuotas.Amortable[(i - PendienteIndex)].Fecha = moment(c.saldos[i].fecha).format("YYYY-MM-DD");
							}
							//console.log(Cuotas);
							Ctrl.Amortable = Cuotas.Amortable;
							Ctrl.AmortableRes = Cuotas.AmortableRes;
							Ctrl.Cuota = Cuotas.Cuota;
						}
					}

					Ctrl.Deuda = Deuda;
				}
			}

			//Obtener los nuevos estados
			angular.forEach(c.saldos, function(s){
				if(s.due && s.mora == 0 && s.pendiente == 0){
					s.estado = 'Pagado';	
				}
				s.estado_color = Ctrl.Colors[s.estado][0];
			});

			if(Disponible > 0) p.Devolver = Disponible;

			//Fix el cliente no desea que se tengan valores devueltos
			if(p.Devolver > 0){
				p.Valor = p.Valor - p.Devolver;
			}

			//console.log(PendienteMora, Pendiente, PendienteMora+Pendiente);
		});






		Ctrl.ConfirmAction = function(Msg, Payload){
			$mdToast.showSimple(Msg);
			$mdDialog.hide(Payload);
		}

		Ctrl.SavePago = function(){
			
			if(Ctrl.Pago.Valor == 0){ return false; }

			$http.post('/api/creditos/pay', { 
				CredSel: Ctrl.CredSel,
				Pago: Ctrl.Pago, 
				Pagos: Ctrl.Pagos,
				Amortable: Ctrl.Amortable,
			}).then(function(res){
				//console.log(res.data);
				Ctrl.ConfirmAction('Pago Realizado', res.data);
			});
		}

	}
]);