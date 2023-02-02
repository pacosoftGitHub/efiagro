angular.module('appRoutes', [])
.config(['$stateProvider', '$urlRouterProvider', '$httpProvider', 
	function($stateProvider, $urlRouterProvider, $httpProvider){

		$stateProvider
			.state('Login', {
				url: '/Login',
				templateUrl: '/Login'
			})
			.state('Home', {
				url: '/Home',
				templateUrl: '/Home',
				resolve: {
					promiseObj: ($rootScope, $localStorage, $http) => {
						return $http.post('api/usuario/revisar-token', { token: $localStorage.token });
					},
					controller: ($rootScope, $localStorage, promiseObj) => {
						$rootScope.Usuario = promiseObj.data;
					}
				}
			})
			.state('Home.Seccion', {
				url: '/:seccion',
				templateUrl: (params) => { return '/Home/' + params.seccion; }
			})
			.state('Home.Seccion.Subseccion', {
				url: '/:subseccion',
				templateUrl: (params) => { return '/Home/' + params.seccion + '/' + params.subseccion }
			});

		$urlRouterProvider.otherwise('/Home');

		$httpProvider.interceptors.push(['$q', '$localStorage', 
			function ($q, $localStorage) {
				return {
					request: function (config) {
						config.headers = config.headers || {};
						if ($localStorage.token) {
							config.headers.token = $localStorage.token;
						}
						return config;
					},
					response: function (res) {
						return res || $q.when(res);
					},
					responseError: function(rejection) {

					  if ([400, 401, 412].indexOf(rejection.status) !== -1) {
						location.replace("/#/Login");
					  }

					  return $q.reject(rejection);
					}

				};
			}
		]);
	}
]);