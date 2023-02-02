angular.module('FondoRotatorio_MisCreditosCtrl', [])
.controller('FondoRotatorio_MisCreditosCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 
	function($scope, $rootScope, $http, $injector, $mdDialog) {

		//console.info('FondoRotatorio_MisCreditosCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;
	
		Ctrl.CreditosCRUD = $injector.get('CRUD').config({ 
			base_url: '/api/creditos/crud',
		});

		Ctrl.getListado = () => {
			Ctrl.CreditosCRUD
				.setScope('mios', null)
				.get().then(() => {
				
			});
		};

		Ctrl.printCredit = function(C, ev){

			var Organizacion = Rs.Usuario.organizaciones.find(e => e.id == Rs.Usuario.organizacion_id);
			console.log(Rs.Usuario);
			$http.get('/api/creditos/?id='+C.id).then(function(res){
				$mdDialog.show({
					controller: 'FondoRotatorio__Creditos_CreditoDialogCtrl',
					templateUrl: '/Frag/FondoRotatorio.Creditos_CreditoDialog',
					clickOutsideToClose: true,
					locals: { Organizacion, CredSel: res.data, Asociado: Rs.Usuario },
					fullscreen: true,
					targetEvent: ev,
				});
			});


		}

		Ctrl.getListado();

	}
]);