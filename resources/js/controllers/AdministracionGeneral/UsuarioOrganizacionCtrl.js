angular.module('UsuarioOrganizacionCtrl', ['ngFileUpload']) //ngFileUpload
    .controller('UsuarioOrganizacionCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'DatosUsuario',
        function($scope, $rootScope, $http, $injector, $mdDialog, DatosUsuario) {

            var Ctrl = $scope;
            var Rs = $rootScope;
            Ctrl.Cancel = $mdDialog.cancel;
            Ctrl.DatosUsuario = DatosUsuario;

            // Cargar las organizaciones del usuario seleccionado
            $http.post('api/organizaciones/usuario', {
                usuario: Ctrl.DatosUsuario.id
            }).then(res => {
                if (res.data.length > 0) {
                    Ctrl.Organizaciones = res.data;
                    // console.log(Ctrl.Organizaciones);
                }
            });

            // Cargar las organizaciones que no han sido asignadas al usuario
            $http.post('api/organizaciones/noasignada', {
                usuario: Ctrl.DatosUsuario.id
            }).then(res => {
                if (res.data.length > 0) {
                    Ctrl.Noasignada = res.data;
                    // console.log(Ctrl.Noasignada);
                }
            });

            Ctrl.agregarOrganizacion = (O) => {
                $http.post('api/organizaciones/crearusuarioorganizacion', {
                    organizacion: O,
                    usuario: Ctrl.DatosUsuario.id
                });
                Ctrl.Cancel();
            };

        }
    ]);