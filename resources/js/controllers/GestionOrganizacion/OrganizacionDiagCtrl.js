angular.module('OrganizacionDiagCtrl', [])
.controller('OrganizacionDiagCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Organizacion',
	function($scope, $rootScope, $http, $injector, $mdDialog, Organizacion) {

		console.info('OrganizacionDiagCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;

		Ctrl.Salir = $mdDialog.cancel;
		Ctrl.Organizacion = Organizacion;
	}
]);