angular.module('Estadisticas__Chart_BarCtrl', [])
.controller('Estadisticas__Chart_BarCtrl', ['$scope', '$rootScope', '$http', 
	function ($scope, $rootScope, $http) {

		//console.info('-> Estadisticas -> Chart -> Bar');

		var Ctrl = $scope;
		var Rs = $rootScope;
        var Prnt = Ctrl.$parent;

		Ctrl.Init = function(k) {
			Ctrl.S = Prnt.RepSel.sections[k];
		}

		Ctrl.options = {
            chart: {
                type: 'multiBarHorizontalChart',
                margin: { top: 0, right: 30, bottom: 30, left: 280 },
                height: 360,
                stacked: false,
                x: function(d){ return d[0]; },
                y: function(d){ return d[1]; },
                groupSpacing: 0.2,
                showControls: false,
                showValues: true,
                valueFormat: function(d){ return Prnt.Format(d, Ctrl.S.L.chart.yAxisFormat); },
                yAxis: {
                    tickFormat: function(d){ return Prnt.Format(d, Ctrl.S.L.chart.yAxisFormat); }
                },
                useInteractiveGuideline: false,
                noData: 'Sin Datos',
            },
        };

        angular.extend(Ctrl.options.chart, Ctrl.S.L.chart);

        Ctrl.Download = function(){
            
            var Headers = [''];
            var Rows = [];
            var L = Ctrl.S.L;
            L.Ext = 'xls';

            angular.forEach(L.data, function(serie) {
                this.push(serie.key);
            }, Headers);

            angular.forEach(L.data[0].values, function(val) {
                this.push([val[0]]);
            }, Rows);

            angular.forEach(L.data, function(serie, ks) {
                angular.forEach(serie.values, function(val, k) {
                    Rows[k][(ks+1)] = val[1];
                });
            });

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