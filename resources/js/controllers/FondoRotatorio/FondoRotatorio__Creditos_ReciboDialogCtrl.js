angular.module('FondoRotatorio__Creditos_ReciboDialogCtrl', [])
.controller('FondoRotatorio__Creditos_ReciboDialogCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Recibo', 'Organizacion', 'CredSel', 'Asociado',
	function($scope, $rootScope, $http, $injector, $mdDialog, Recibo, Organizacion, CredSel, Asociado) {

		console.info('FondoRotatorio__Creditos_ReciboDialogCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;

		Ctrl.Recibo = Recibo;
		Ctrl.Organizacion = Organizacion;
		Ctrl.CredSel = CredSel;
		Ctrl.Asociado = Asociado;
		Ctrl.MyUser = Rs.Usuario;

		Ctrl.Title = 'Imprimir Recibo No. '+Recibo.id;
		Ctrl.Cancel = function(){ $mdDialog.cancel(); }

	}
]);