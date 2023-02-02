angular.module('FondoRotatorio_NuevoCreditoDiagCtrl', [])
.controller('FondoRotatorio_NuevoCreditoDiagCtrl', ['$scope', '$rootScope', '$injector', '$mdDialog', '$mdToast', '$http', 'CreditoSrv', 'Asociado', 'myUser', 'Parent', 'Simulate',
	function($scope, $rootScope, $injector, $mdDialog, $mdToast, $http, CreditoSrv, Asociado, myUser, Parent, Simulate) {

		console.info('FondoRotatorio_NuevoCreditoDiagCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;
	
		Ctrl.Theme = 'Snow_White';
		Ctrl.Title = '';
		Ctrl.Parent = Parent;
		Ctrl.Simulate = Simulate;
		Ctrl.Hoy = moment().format('L');
		Ctrl.myUser = myUser;

		Ctrl.Cancelar = function(){ $mdDialog.cancel(); }

		Ctrl.Scales = CreditoSrv.Scales;
		Ctrl.Lineas = Parent.Vars.LINEAS_CREDITO;
		Ctrl.changeInterest = Boolean(Parent.Vars.CREDITO_CAMBIAR_INTERES);
		
		Ctrl.Credit = {
			Linea: Ctrl.Lineas[0],
			Monto: 1000000,
			Periodos: 6,
			Periodos_Gracia: 0,
			Interes: angular.copy(Parent.Vars.CREDITO_INTERES) / 100,
			Cada: Ctrl.Scales['1_M'],
			Cuota: 0,
			Primer_Pago: moment().toDate(),

		};
		Ctrl.Amortable = null;
		Ctrl.AmortableRes = null;
		Ctrl.Title = 'Nuevo Crédito';

		if(Simulate) Ctrl.Title = 'Simular Crédito';

		Ctrl.$watchCollection('Credit', function(c, o){

			Ctrl.Amortable = null;
			Ctrl.AmortableRes = null;

			if(c.Monto > 0 && c.Periodos > 0 && c.Interes > 0){
				var Cuotas = CreditoSrv.CalcCuotas(c.Monto, c.Interes, c.Cada.key, c.Periodos, c.Periodos_Gracia, c.Primer_Pago, 1);

				Ctrl.Amortable = Cuotas.Amortable;
				Ctrl.AmortableRes = Cuotas.AmortableRes;
				c.Cuota = Cuotas.Cuota;
			}

		 });

		Ctrl.ConfirmAction = function(Msg, data){
			console.info(data);
			$mdToast.showSimple(Msg);
			$mdDialog.hide(data);
		}

		Ctrl.SaveCredit = function(){
			if(Simulate) return false;

			let Credit = angular.copy(Ctrl.Credit);

			Credit.Fecha = moment(Credit.Primer_Pago).format('YYYY-MM-DD');

			var Daten = {
				Credit: Credit,
				Amortable: Ctrl.Amortable,
				AmortableRes: Ctrl.AmortableRes,
				Asociado: Asociado,
				User: myUser
			};

			$http.post('/api/creditos/add', Daten).then(function(res){
				//Ctrl.Creditos = res.data;
				// console.log('CredAdded', res.data);
				Ctrl.ConfirmAction('Crédito Creado', res.data);
				//Ctrl.ViewCredit(Ctrl.Creditos[0]); //REMOVE
			});

			
		}

	}
]);