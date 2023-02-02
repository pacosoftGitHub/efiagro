angular.module('FincaDiagCtrl', [])
.controller('FincaDiagCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Finca', 
	function($scope, $rootScope, $http, $injector, $mdDialog, Finca) {

		console.info('FincaDiagCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;

		Ctrl.Salir = $mdDialog.cancel;
		Ctrl.Finca = Finca;
		// Ctrl.Tarea = Tarea;
		
	}
]);