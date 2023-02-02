angular.module('FondoRotatorio__Creditos_CreditoDialogCtrl', [])
.controller('FondoRotatorio__Creditos_CreditoDialogCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Organizacion', 'CredSel', 'Asociado',
	function($scope, $rootScope, $http, $injector, $mdDialog, Organizacion, CredSel, Asociado) {

		console.info('FondoRotatorio__Creditos_CreditoDialogCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;

		Ctrl.Organizacion = Organizacion;
		Ctrl.CredSel = CredSel;
		Ctrl.Asociado = Asociado;
		
		Ctrl.Hoy = moment().format('YYYY-MM-DD HH:mm');
		Ctrl.MyUser = Rs.Usuario;
	
		Ctrl.Title = 'Imprimir Comprobante: Credito Cod. '+CredSel.id;
		Ctrl.Cancel = function(){ $mdDialog.cancel(); }

	}
]);