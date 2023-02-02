angular.module('FondoRotatorio_CreditosCtrl', [])
.controller('FondoRotatorio_CreditosCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', '$mdToast',
	function($scope, $rootScope, $http, $injector, $mdDialog, $mdToast) {

		console.info('FondoRotatorio_CreditosCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;
		Ctrl.AsociadosNav = true;
		Ctrl.Asociado = null;
	
		Ctrl.buscarAsociados = (query) => {
			// console.log(Rs.Usuario.perfil_id);
            if ( Rs.Usuario.perfil_id == 2 ) {
                return Rs.http('api/usuario/buscar-usuario-organizacion', {
                    'query': query,
                    'organizacion': Rs.Usuario.organizacion_id
                });
            } else {
                return Rs.http('api/usuario/buscar-usuario', { 'query': query });
            }
		};

		Ctrl.selectAsociado = (Asociado) => {
			Ctrl.Asociado = Asociado;
			Ctrl.LoadCreditos();
		}

		Ctrl.nuevoCredito = function(){
			$mdDialog.show({
				controller: 'FondoRotatorio_NuevoCreditoDiagCtrl',
				templateUrl: '/Frag/FondoRotatorio.Creditos_NuevoCreditoDiag',
				clickOutsideToClose: false,
				locals: { Asociado: Ctrl.Asociado, myUser: Rs.Usuario, Parent: Ctrl, Simulate: false },
				fullscreen: false,
			}).then(function(Cred) { 
				//Ctrl.ViewCredit(Cred);
				Ctrl.LoadCreditos();
			});
		}


		Ctrl.LoadCreditos = function(){
			if(!Ctrl.Asociado) return;
			$http.post('/api/creditos/get', { asociado_id: Ctrl.Asociado.id }).then(function(res){
				Ctrl.Creditos = res.data;
				Ctrl.CredSel = null;
				//Ctrl.ViewCredit(Ctrl.Creditos[0]); //FIX
			});
		}

		Ctrl.ViewCredit = function(Cred){
			
			if (!angular.isDefined(Cred)) return false;
			$http.get('/api/creditos/?id='+Cred.id).then(function(res){
				Ctrl.CredSel = res.data;
				//Ctrl.NewAbono(); //FIX
				//Ctrl.PrintCredit(); //FIX
				//Ctrl.PrintRecibo(null, Ctrl.CredSel.recibos[0]); //FIX
			});

		}

		Ctrl.PrintCredit = function(ev){

			var Organizacion = Rs.Usuario.organizaciones.find(e => e.id == Rs.Usuario.organizacion_id);

			$mdDialog.show({
				controller: 'FondoRotatorio__Creditos_CreditoDialogCtrl',
				templateUrl: '/Frag/FondoRotatorio.Creditos_CreditoDialog',
				clickOutsideToClose: true,
				locals: { Organizacion, CredSel: Ctrl.CredSel, Asociado: Ctrl.Asociado },
				fullscreen: true,
				targetEvent: ev,
			});
		}

		function s2ab(s) {
            var buf = new ArrayBuffer(s.length);
            var view = new Uint8Array(buf);
            for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
            return buf;        
        }

        function excelColName(n) {
			var ordA = 'a'.charCodeAt(0);
			var ordZ = 'z'.charCodeAt(0);
			var len = ordZ - ordA + 1;

			var s = "";
			while(n >= 0) {
				s = String.fromCharCode(n % len + ordA).toUpperCase() + s;
				n = Math.floor(n / len) - 1;
			}
			return s;
		}

		Ctrl.DownloadCreditsList = function() {
			$http.post('/api/creditos/rep-det-creditos', { f: { Asociado_id: Ctrl.Asociado.id, orderBy: 'id', orderSort: 'DESC' } }).then(function(r) {

				var wb = XLSX.utils.book_new();
				var Titulo = 'Creditos de '+Ctrl.Asociado.nombre;
		        wb.Props = {
		            Title: Titulo,
		            CreatedDate: new Date()
		        };

		        var SheetData = [ [] ];
		        var ColumnsNo = 0;
		        angular.forEach(r.data.data.Headers, C => {
					SheetData[0].push(C);
					ColumnsNo++;
		        });

		        r.data.data.Rows.forEach((Row) => {
		        	var RowData = [];
		        	angular.forEach(r.data.data.Headers, (C,kC) => {
		        		RowData.push(Row[kC]);
			        });
			        SheetData.push(RowData);
		        });

		        console.log(SheetData);

				var ws = XLSX.utils.aoa_to_sheet(SheetData);
				var last_cell = excelColName(ColumnsNo - 1) + (r.data.data.Rows.length + 1);
				ws['!autofilter'] = { ref: ('A1:'+last_cell) };
		        
		        XLSX.utils.book_append_sheet(wb, ws, "Creditos");
		        var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
		     
		        saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), Titulo + '.xlsx');
			});
		}

		Ctrl.NewAbono = function(ev){
			$mdDialog.show({
				controller: 'FondoRotatorio_Creditos_PayDialogCtrl',
				templateUrl: '/Frag/FondoRotatorio.Creditos_PayDialog',
				clickOutsideToClose: false,
				locals: { CredSel: Ctrl.CredSel, Parent: Ctrl },
				fullscreen: true,
				targetEvent: ev,
			}).then(function() { 
				Ctrl.ViewCredit(Ctrl.CredSel);
			});
		}

		Ctrl.PrintRecibo = function(ev, Recibo){
			var Organizacion = Rs.Usuario.organizaciones.find(e => e.id == Rs.Usuario.organizacion_id);

			$mdDialog.show({
				controller: 'FondoRotatorio__Creditos_ReciboDialogCtrl',
				templateUrl: '/Frag/FondoRotatorio.Creditos_ReciboDialog',
				clickOutsideToClose: false,
				locals: { Recibo: Recibo, Organizacion, CredSel: Ctrl.CredSel, Asociado: Ctrl.Asociado },
				fullscreen: true,
				targetEvent: ev,
			});
		}

		Ctrl.DeleteCredit = function(ev) {
			var confirm = $mdDialog.confirm()
							.title('BORRAR el crédito Cod. '+Ctrl.CredSel.id+'?')
							.textContent('ESTA ACCIÓN NO SE PUEDE DESHACER.')
							.ariaLabel('Borrar')
							.targetEvent(ev)
							.theme('Danger')
							.ok('BORRAR CRÉDITO')
							.cancel('Cancelar');
			$mdDialog.show(confirm).then(function() {
				
				$http.post('/api/creditos/delete', { id: Ctrl.CredSel.id }).then(function(res){
					$mdToast.showSimple('Borrado');
					Ctrl.CredSel = null;
					Ctrl.LoadCreditos();
				});

			});
		}

		Ctrl.DeleteRecibo = function(ev, Recibo) {
			var confirm = $mdDialog.confirm()
							.title('BORRAR el Recibo Cod. '+Recibo.id+'?')
							.textContent('ESTA ACCIÓN NO SE PUEDE DESHACER.')
							.ariaLabel('Borrar')
							.targetEvent(ev)
							.theme('Danger')
							.ok('BORRAR RECIBO')
							.cancel('Cancelar');
			$mdDialog.show(confirm).then(function() {
				
				$http.post('/api/creditos/delete-recibo', { id: Recibo.id }).then(function(res){
					$mdToast.showSimple('Borrado');
					Ctrl.ViewCredit(Ctrl.CredSel);
				});

			});
		}

		//Obtener Opciones
		Ctrl.getOpciones = () => {
			return Rs.http('api/opciones/get-opciones', {organizacion_id :  Rs.Usuario.organizacion_id}, Ctrl, 'Vars');
		}

		Ctrl.getOpciones();

		//Testing
		/*Rs.http('api/usuario/buscar-usuario', { 'query': '1093' }).then(r => {
			Ctrl.Asociado =  r[0];
			Ctrl.LoadCreditos();
			//Ctrl.nuevoCredito();
		});*/

	}
]);