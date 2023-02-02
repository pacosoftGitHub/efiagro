angular.module('Zonas_ZonaEditorCtrl', [])
.controller('Zonas_ZonaEditorCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Zona',
	function($scope, $rootScope, $http, $injector, $mdDialog, Zona) {
		var Ctrl = $scope;
		var Rs = $rootScope;

		Ctrl.Cancel = $mdDialog.cancel;

		Ctrl.Zona = angular.copy(Zona);

		// Ctrl.zonasCRUD = $injector.get('CRUD').config({ 
		// 	base_url: '/api/zonas/zonas',
		// 	limit: 1000,
		// 	add_append: 'refresh',
		// });

		// Ctrl.getZonas = () => {
		// 	Ctrl.ZonasCRUD.setScope('lazona', Zona.id).get();
		// };

		Ctrl.getZonas();

		
        Ctrl.guardarZona = () => {
            Ctrl.ZonasCRUD.update(Ctrl.Zona).then(() => {
						Rs.showToast("Zona Actualizada");
                
            });
        }

		$http.post('api/lineasproductivas/obtener', {}).then(r => {
			Ctrl.lineas_productivas = r.data;
			
		    });

	}
]);