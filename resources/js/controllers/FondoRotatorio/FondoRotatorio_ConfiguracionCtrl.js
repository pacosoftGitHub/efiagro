angular.module('FondoRotatorio_ConfiguracionCtrl', ['ngMaterial'])
.controller('FondoRotatorio_ConfiguracionCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', '$mdToast',
	function($scope, $rootScope, $http, $injector, $mdDialog, $mdToast) {

		console.info('FondoRotatorio_ConfiguracionCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;
		Ctrl.AsociadosNav = true;
		Ctrl.Asociado = null;

        Ctrl.organizacion_id = Rs.Usuario.organizacion_id;
		Ctrl.intereses = null;
	
		
		//Obtener Opciones
		Ctrl.getOpciones = () => {

			resultado = Rs.http('api/opciones/get-opciones', {organizacion_id : Ctrl.organizacion_id});
			resultado.then((r) => {
				//Ctrl.intereses_actuales = r;
				Ctrl.intereses = {
					interes: r.CREDITO_INTERES,
					interes3160: r.CREDITO_MORA_31_60,
					interes6190: r.CREDITO_MORA_61_90,
					interes91120: r.CREDITO_MORA_91_120,
					interesmas120: r.CREDITO_MORA_MAS_120,
					interesmenos30: r.CREDITO_MORA_MENOS_30,
				};
			});
			// resultado.then(function(r){
			// 	console.log(r.data);
			// });
		}

		Ctrl.getOpciones();


		Ctrl.actualizar = () => {
			$http.post('api/opciones/actualizar',{intereses : JSON.stringify(Ctrl.intereses), organizacion_id : Ctrl.organizacion_id})
			.then( (r) => {

				if(!r){
					Rs.showToast('Falló la actualización')
					return;
				}

				console.log(r)

			} );
		}

		

	}
]);