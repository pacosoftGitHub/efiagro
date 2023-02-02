angular.module('Estadisticas__Data_RemarkCtrl', [])
.controller('Estadisticas__Data_RemarkCtrl', ['$scope', '$rootScope', '$http', 
	function ($scope, $rootScope, $http) {

		//console.info('-> Estadisticas -> Data -> Remark');

		var Ctrl = $scope;
		var Rs = $rootScope;
        var Prnt = Ctrl.$parent;

		Ctrl.Init = function(k) {
			Ctrl.S = Prnt.RepSel.sections[k];
		}

        Ctrl.Download = function(){
            
            var Headers = ['Dato', 'Valor'];
            var Rows = [];
            var L = Ctrl.S.L;
            L.Ext = 'xls';

            angular.forEach(L.data, function(serie) {
                this.push([ serie.key, serie.value ]);
            }, Rows);

            //console.info(L, Headers, Rows);
            //return false;

            var file = L.Titulo + '.' + L.Ext;
            var Excel = {
                filename: L.Titulo,
                ext: L.Ext,
                sheets: [
                    {
                        headers: Headers,
                        rows: Rows,
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