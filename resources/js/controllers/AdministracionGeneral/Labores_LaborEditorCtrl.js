angular.module('Labores_LaborEditorCtrl', [])
.controller('Labores_LaborEditorCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Labor',
	function($scope, $rootScope, $http, $injector, $mdDialog, Labor) {

		var Ctrl = $scope;
		var Rs = $rootScope;

		Ctrl.Cancel = $mdDialog.cancel;

		Ctrl.Labor = angular.copy(Labor);

		// Ctrl.LaboresCRUD = $injector.get('CRUD').config({ 
		// 	base_url: '/api/labores/labores',
		// 	limit: 1000,
		// 	add_append: 'refresh',
		// });

		// Ctrl.getLabores = () => {
		// 	Ctrl.LaboresCRUD.setScope('milabor', Labor.id).get();
		// };

		Ctrl.getLabores();

		
        Ctrl.guardarLabor = () => {
            Ctrl.LaboresCRUD.update(Ctrl.Labor).then(() => {
						Rs.showToast("Labor Actualizada");
                
            });
        }

		$http.post('api/lineasproductivas/obtener', {}).then(r => {
			Ctrl.lineas_productivas = r.data;
			
		});

		$http.post('api/zonas/obtener', {}).then(r => {
			Ctrl.zonas = r.data;
			
		});

	}
]);