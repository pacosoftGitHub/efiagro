angular.module('Estadisticas__Table_BasicCtrl', [])
.controller('Estadisticas__Table_BasicCtrl', ['$scope', '$rootScope', '$http',
	function ($scope, $rootScope, $http) {

		//console.info('-> Estadisticas -> Chart -> Pie');

		var Ctrl = $scope;
		var Rs = $rootScope;
        var Prnt = Ctrl.$parent;

		Ctrl.Init = function(k) {
			Ctrl.S = Prnt.RepSel.sections[k];
		}

		Ctrl.OrderBy = null;
        Ctrl.Filter = null;

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

        	$http.post('/api/main/hacer-excel', {E: Excel}, { responseType: 'arraybuffer' }).then(function(r) {
        		var blob = new Blob([r.data], { type: "application/vnd.ms-excel; charset=UTF-8" });
		        saveAs(blob, file);
        	});
        }
	}

]);