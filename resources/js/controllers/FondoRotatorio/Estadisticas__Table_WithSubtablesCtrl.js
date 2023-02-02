angular.module('Estadisticas__Table_WithSubtablesCtrl', [])
.controller('Estadisticas__Table_WithSubtablesCtrl', ['$scope', '$rootScope', '$mdDialog', '$http', 
	function ($scope, $rootScope, $mdDialog, $http) {

	//console.info('-> Estadisticas -> Chart -> Pie');

	var Ctrl = $scope;
	var Rs = $rootScope;
        var Prnt = Ctrl.$parent;

	Ctrl.Init = function(k) {
		Ctrl.S = Prnt.RepSel.sections[k];
	}

	Ctrl.OrderBy = null;
        Ctrl.Filter = null;

        Ctrl.GetUrl = function(B){
        	return (B.Action == 'Download') ? B.Url : null;
        }

        Ctrl.Download = function(){
        	//console.info(Ctrl.S);
        	var Data = Ctrl.S.L.data;
        	var file = Data.Filename + '.' + Data.Ext;
        	var Excel = {
        		filename: Data.Filename,
        		ext: Data.Ext,
        		sheets: [
        			{
        				name: Data.Filename,
        				headers: Data.Headers,
        				rows: Data.Rows,
        			}
        		]
        	}

                Rs.DownloadExcel(Excel);
        }

        Ctrl.Button = function(B, R, ev){
        	if(B.Action == 'Rep'){

        		var f = angular.extend({}, Prnt.RepSel.f, { selectedRow: R } );

        		$mdDialog.show({
					controller: 'Estadisticas_RepDialogCtrl',
					templateUrl: '/Frag/FondoRotatorio.Estadisticas_RepDialog',
					locals: { B: B, R: R, f: f },
					clickOutsideToClose: true,
					fullscreen: true,
					targetEvent: ev,
				});
        	}
        }
	}

]);