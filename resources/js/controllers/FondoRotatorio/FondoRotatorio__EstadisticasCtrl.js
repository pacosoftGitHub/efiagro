angular.module('FondoRotatorio__EstadisticasCtrl', [])
.controller('FondoRotatorio__EstadisticasCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 
	function($scope, $rootScope, $http, $injector, $mdDialog) {

		console.info('FondoRotatorio__EstadisticasCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;
	
		$http.get('api/reps').then(function(r){
			Ctrl.Reps = r.data;
		});

		Ctrl.SelectRep = function() {
			$http.post('api/reps/get', { id: Ctrl.RepId.id }).then(function(r){
				var Rep = r.data;
				var filters = [];
				angular.forEach(Rep.filters, function(v) {
					this.push(Ctrl.PrepFilters(v));
				}, filters);
				Rep.filters = filters;
				Ctrl.RepSel = Rep;

				Ctrl.Load();
			});
		}

		Ctrl.PrepFilters = function(f){

			if(f.Type == 'Date'){
				if(f.Default !== null){
					f.Value = moment(f.Default, "YYYY-MM-DD").toDate();
				}else{
					var Pat = f.Pattern.split('_');
					var D = moment().add(Pat[0], Pat[1]);
					if(Pat[2] == 'S') D = D.startOf('month');
					if(Pat[2] == 'E') D = D.endOf('month'); 
					f.Value = D.toDate();
				}
			}else if(f.Type == 'Select'){
				f.Value = f.Default;
				f.Pattern = f.Pattern.split('|');
			}else if(f.Type == 'Number'){
				f.Value = parseInt(f.Default);
			}

			return f;
		}

		Ctrl.Load = function() {
			var Filters = {};
			angular.forEach(Ctrl.RepSel.filters, function(f) {
				var Val = f.Value;
				if(f.Type == 'Date') Val = moment(Val).format('YYYY-MM-DD');
				this[f.Name] = Val;
			}, Filters);

			Ctrl.RepSel.f = Filters;

			angular.forEach(Ctrl.RepSel.sections, function(s) {
				s.Loaded = false;
			});

			Ctrl.Loaded = 0;

			Ctrl.LoadSection(Filters);
		};

		Ctrl.LoadSection = function(Filters) {
			var S = Ctrl.RepSel.sections[Ctrl.Loaded];
			S.L = null;

			$http.post(S.Route, { f: Filters }).then(function(r){
				S.Loaded = true;
				S.L = r.data;

				Ctrl.Loaded++;
				if(Ctrl.Loaded <= (Ctrl.RepSel.sections.length - 1)) Ctrl.LoadSection(Filters);
			});
		}

		Ctrl.Format = function(v, pattern, extra) {
			switch (pattern) 
			{
				case "Money": return d3.format('$,')(v);
				case "Number": return d3.format(',')(v);
				case "Date_Full": d3.time.format('%x')(new Date(v*1000));
				default: return v;
			} 
		}

	}
]);