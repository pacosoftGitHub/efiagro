angular.module('Estadisticas_RepDialogCtrl', [])
.controller(   'Estadisticas_RepDialogCtrl', ['$scope', '$mdDialog', '$http', 'B', 'R', 'f',
	function ($scope, $mdDialog, $http, B, R, f) {

		var Ctrl = $scope;

		Ctrl.RepSel = {
			sections: [ B ],
		};
		Ctrl.R = R;

		Ctrl.Cancel = function(){
			$mdDialog.cancel();
		}
		Ctrl.RepSel.sections[0].Loaded = false;
		$http.post(Ctrl.RepSel.sections[0].Url, {f: f}).then(function(r){
			Ctrl.RepSel.sections[0].Loaded = true;
			Ctrl.RepSel.sections[0].L = r.data;
		});

	}

]);