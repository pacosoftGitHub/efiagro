angular.module('RelsManagerCtrl', [])
.controller('RelsManagerCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Config', 
	function($scope, $rootScope, $http, $injector, $mdDialog, Config) {

		console.info('RelsManagerCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;
		
		Ctrl.Cancel = function(){ $mdDialog.cancel(); }
		
		Ctrl.Config = {
			Titulo: 'Gestionar Relaciones',
			Theme: 'Snow_White', 
		};
		
		angular.extend(Ctrl.Config, Config);

	}
]);