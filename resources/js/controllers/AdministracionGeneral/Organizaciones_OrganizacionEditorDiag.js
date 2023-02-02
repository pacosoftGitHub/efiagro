angular.module('Organizaciones_OrganizacionEditorCtrl', [])
.controller('Organizaciones_OrganizacionEditorCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Articulo',
	function($scope, $rootScope, $http, $injector, $mdDialog, Articulo) {

		var Ctrl = $scope;
		var Rs = $rootScope;

		Ctrl.Cancel = $mdDialog.cancel;

		Ctrl.Caso = angular.copy(Caso);

		Ctrl.SeccionesCRUD = $injector.get('CRUD').config({ 
			base_url: '/api/organizaciones/secciones',
			limit: 1000,
			add_append: 'refresh',
		});

		Ctrl.getSecciones = () => {
			Ctrl.SeccionesCRUD.setScope('laorganizacion', Organizacion.id).get();
		}
		Ctrl.getOrganizaciones();

	}
]);