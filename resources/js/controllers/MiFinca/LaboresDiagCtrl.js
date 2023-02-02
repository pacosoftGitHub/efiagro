angular.module('LaboresDiagCtrl', [])
.controller('LaboresDiagCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Labor', 
	function($scope, $rootScope, $http, $injector, $mdDialog, Labor) {

		console.info('LaboresDiagCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;

		Ctrl.Salir = $mdDialog.cancel;
		Ctrl.Labor = Labor;
		
		
	}
]);
