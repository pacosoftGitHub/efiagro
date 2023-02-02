angular.module('CultivoDiagCtrl', [])
.controller('CultivoDiagCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Finca', 
	function($scope, $rootScope, $http, $injector, $mdDialog, Finca) {

		console.info('CultivoDiagCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;

		Ctrl.Salir = $mdDialog.cancel;
		Ctrl.Cultivo = Cultivo;	
	}
]);