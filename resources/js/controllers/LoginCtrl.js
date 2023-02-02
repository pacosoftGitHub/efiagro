angular.module('LoginCtrl', [])
.controller('LoginCtrl', ['$rootScope', '$http', '$state', '$localStorage', '$mdToast', 
	function($rootScope, $http, $state, $localStorage, $mdToast){

		var Rs = $rootScope;
		delete $localStorage.token;

		// Formulario de inicio: cargar datos en blanco.
		Rs.Usuario = {
			Correo:'', // 'info@mbrain.co',
			Password: '' // '123'
		};

		// Funcion para enviar datos al server y validar la sesion del usuario.
		Rs.enviarLogin = (ev) => {
			ev.preventDefault();
			$http.post('/api/usuario/login', { Credenciales: Rs.Usuario })
			.then((r) => {
				
				/*Operaciones originales al logearse
				let token = r.data;
				$localStorage.token = token;
				$state.go('Home');
				*/

				/*Operaciones nuevas para logearse*/
				let token = r.data.token;
				let perfil = r.data.perfil_id;
				$localStorage.token = token;
				if(perfil == 4){
					$state.go('Home.Seccion.Subseccion', { 
						seccion: "GestionOrganizacion", 
						subseccion: "Organizacion"
					});
				}else{
					$state.go('Home');
				}
				
			}).catch( resp => {
				// Retorno de mensaje, en caso de datos NO validos.
				Rs.showToast(resp.data.Msg);
			});
		}

		Rs.def = function(arg, def) {
			return (typeof arg == 'undefined' ? def : arg);
		};

		// Configuracion de TOAST para la carga de mensajes.
		Rs.showToast = function(Msg, Type, Delay = 5000, Position){
			var Type = Rs.def(Type, 'Normal');
			var Position = Rs.def(Position, 'bottom left')
			var Templates = {
				Normal: '<md-toast class="md-toast-normal"><span flex>' + Msg + '<span></md-toast>',
				Error:  '<md-toast class="md-toast-error"><span flex>' + Msg + '<span></md-toast>',
				Success:  '<md-toast class="md-toast-success"><span flex>' + Msg + '<span></md-toast>',
			};
			return $mdToast.show({
				template: Templates[Type],
				hideDelay: Delay,
				position: Position
			});
		};

	}
]);
