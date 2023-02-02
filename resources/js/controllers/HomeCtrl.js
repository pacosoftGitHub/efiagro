angular.module('HomeCtrl', [])
    .controller('HomeCtrl', ['$scope', '$rootScope', '$http', '$state', '$mdDialog', '$location', 'appFunctions',
        function($scope, $rootScope, $http, $state, $mdDialog, $location, appFunctions) {

            var Ctrl = $scope;
            var Rs = $rootScope;

            // Controlador para validar al momento de cerrar la session del usuario.
            Ctrl.Logout = () => {
                let confirm = $mdDialog.confirm()
                    .title('¿Desea salir del aplicativo?')
                    .ok('Cerrar Sesion')
                    .cancel('Regresar');

                $mdDialog.show(confirm).then(() => {
                    $state.go('Login');
                });
            };


            // Modal para el cambio de clave del usuario productor
            Ctrl.cambiarClave = U => {
            Rs.BasicDialog({
                Flex: 30,
                Title: `Cambiar Clave ${ U.nombres }` ,
                Fields: [
                    {
                        Nombre: "Clave Actual",
                        Value: '', //U.contrasena,
                        Type: "password",
                        Required: true,
                    },
                    {
                        Nombre: "Nueva Clave",
                        Value: '', //U.contrasena,
                        Type: "password",
                        Required: true,
                    },
                    {
                        Nombre: "Confirmar Clave",
                        Value: '', //U.contrasena,
                        Type: "password",
                        Required: true,
                    }
                ],
                Confirm: { Text: "Actualiza Clave" }
            }).then(u => {
                if (!u) return;
                if (u.Fields[0].Value === u.Fields[1].Value){
                    Rs.showToast('La nueva clave debe ser diferente de la anterior', 'Error');
                    return;
                }
                if (u.Fields[1].Value != u.Fields[2].Value){
                    Rs.showToast('La nueva clave debe ser igual a la confirmación');
                    return;
                }
                $http.post('/api/usuario/actualizar-clave-usuario', { claveAnterior: u.Fields[0].Value, claveNueva: u.Fields[1].Value })
                    .then( () => {
                        Rs.showToast("Se cambio la clave.");
                    })
                    .catch(e => {
                        Rs.showToast(e.data.Msg, "Error");
                        console.log(e);
                    });
                /*var nuevaclave = u.Fields[1].Value;
                if ( nuevaclave.trim() != '' ) {
                    var ClaveCambiada = {
                        usuario_id: U.id,
                        contrasena: u.Fields[1].Value,
                    };
                    // Accedemos mediante la API para el cambio de clave.
                    $http.post('/api/usuario/actualizar-clave', ClaveCambiada)
                        .then( () => {
                            Rs.showToast("Se cambio la clave.");
                        });
                } else {
                    Rs.showToast("Se envio la clave en blanco. No se modifica.");
                }*/
            });
        };

            // Cargar el listado de secciones
            Ctrl.obtenerSecciones = () => {
                Ctrl.logoInicio = true;
                $http.post('api/main/obtener-secciones', {}).then(r => {
                    Rs.Secciones = r.data;
                });
            };
            Ctrl.obtenerSecciones();

            // Gestion del Estado
            Rs.cambioEstado = function() {
                Rs.Estado = $state.current;
                Rs.Estado.ruta = $location.path().split('/');
            };

            // Carga del menu segund la seccion cargada
            Rs.navegarSubseccion = (Seccion, Subseccion) => {
                $state.go('Home.Seccion.Subseccion', { 
                    seccion: Seccion, 
                    subseccion: Subseccion 
                });
            };
            
            // Función para actualizar un campo en la tabla del usuario.
            Rs.actualizarUsuario = ( campo, valor ) => {
                if ( !campo || !valor )
                    return;
                    Rs.Usuario.organizacion_id = valor;
                $http.post('api/usuario/actualizarcampo', {
                    usuarioid: Rs.Usuario['id'],
                    campo: campo, 
                    valor: valor
                }).then( () => {
                    $state.reload();
                    // console.log("Recargando Pagina")
                });
            }
            
            // Validar el rol para cargar opciones de organizaciones y fincas
            // Administrador: 1 | Operaor: 2 | Soporte: 3 | Productor: 4 
            switch( parseInt(Rs.Usuario['perfil_id']) ) {
                case 1:
                    Ctrl.listaOrganizacion = false;
                    Ctrl.listaFinca = false;
                    break;
                    
                case 2:
                    Ctrl.listaOrganizacion = true;
                    Ctrl.listaFinca = false;
                    break;
                    
                case 3:
                    Ctrl.listaOrganizacion = false;
                    Ctrl.listaFinca = false;
                    break;
                    
                case 4:
                    Ctrl.listaOrganizacion = true;
                    Ctrl.listaFinca = true;
                    break;

                default:
                    Ctrl.listaOrganizacion = false;
                    Ctrl.listaFinca = false;
                    break;
                    
            }

            Rs.$on("$stateChangeSuccess", Rs.cambioEstado);

            Rs.cambioEstado();
        }
    ]);
