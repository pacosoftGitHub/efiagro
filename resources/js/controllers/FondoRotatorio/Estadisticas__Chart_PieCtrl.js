angular.module('Estadisticas__Chart_PieCtrl', [])
.controller('Estadisticas__Chart_PieCtrl', ['$scope', '$rootScope', '$http', 
	function ($scope, $rootScope, $http) {

		//console.info('-> Estadisticas -> Chart -> Pie');

		var Ctrl = $scope;
		var Rs = $rootScope;
        var Prnt = Ctrl.$parent;

		Ctrl.Init = function(k) {
			Ctrl.S = Prnt.RepSel.sections[k];
		}

		Ctrl.options = {
            chart: {
                type: 'pieChart',
                x: function(d){ return d.key;   },
                y: function(d){ return d.value; },
                color: function(d){ return d.color },
                tooltip: {
                    valueFormatter: function(d) { return Prnt.Format(d, Ctrl.S.L.chart.yAxisFormat); },
                },
                height: 360,
                showLabels: true,
                duration: 500,
                labelThreshold: 0.01,
                labelSunbeamLayout: true,
                noData: 'Sin Datos',
            },
        };

        angular.extend(Ctrl.options.chart, Ctrl.S.L.chart);

        Ctrl.Download = function(){
            
            var Headers = ['Categoria', 'Valor'];
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