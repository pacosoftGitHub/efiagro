angular.module('PerfilesCtrl', [])
    .controller('PerfilesCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog',
        function($scope, $rootScope, $http, $injector, $mdDialog) {
            var Ctrl = $scope;
            var Rs = $rootScope;

            // Obtener la información de los perfiles existentes.
            Ctrl.PerfilesCRUD = $injector.get('CRUD').config({
                base_url: '/api/perfiles/perfiles',
                limit: 100,
                add_append: 'refresh',
            });
            Ctrl.getPerfiles = () => {
                Ctrl.PerfilesCRUD.get().then(() => {
                    Ctrl.abrirPerfil(Ctrl.PerfilesCRUD.rows[0]);
                });
            };

            Ctrl.PerfilesSeccionesCRUD = $injector.get('CRUD').config({
                base_url: '/api/perfiles/secciones',
                limit: 100,
                add_append: 'refresh',
                order_by: ['seccion_id']
            });
            // Ejecutar el metodo para cargar los registros al controlador
            Ctrl.getPerfilesSeccion = () => {
                Ctrl.PerfilesSeccionesCRUD.get().then(() => {});
            };

            // Obtener la información de las secciones existentes.
            Ctrl.SeccionesCRUD = $injector.get('CRUD').config({
                base_url: '/api/secciones/secciones',
                limit: 100,
                add_append: 'refresh',
                order_by: ['seccion', 'subseccion']
            });
            Ctrl.getSecciones = () => {
                return Ctrl.SeccionesCRUD.get().then(() => {
                    Ctrl.secciones = angular.copy(Ctrl.SeccionesCRUD.rows);
                    // Ctrl.SeccionesCRUD.rows.forEach(S => {
                    //     secciones[S.id] = S;
                    // });
                    // Ctrl.secciones = secciones;
                });
            };

            // Ejecutar el metodo para cargar los registros al controlador
            Ctrl.getSecciones().then(Ctrl.getPerfiles());

            // Crear arreglo
            Ctrl.nivelesSeguridad = [
                { 'nivel': 0, 'etiqueta': 'Sin acceso', 'icono': 'fa-lock' },
                { 'nivel': 10, 'etiqueta': 'Visualización', 'icono': 'fa-eye' },
                { 'nivel': 20, 'etiqueta': 'Adición', 'icono': 'fa-plus' },
                { 'nivel': 30, 'etiqueta': 'Edición', 'icono': 'fa-pen' },
                { 'nivel': 40, 'etiqueta': 'Borrado', 'icono': 'fa-trash' },
                { 'nivel': 50, 'etiqueta': 'Control Total', 'icono': 'fa-hdd' },
            ];

            // Función para cargar las secciones segun el perfil seleccionado.
            Ctrl.abrirPerfil = (P) => {
                Ctrl.perfilSel = P;

                Ctrl.PerfilesSeccionesCRUD.setScope('perfil', P.id).get().then(() => {
                    angular.forEach(Ctrl.secciones, S => {
                        S.nivel = 0;
                    });
                    angular.forEach(Ctrl.PerfilesSeccionesCRUD.rows, PS => {
                        var seccion = Ctrl.secciones.find( S => S.id == PS.seccion_id )
                        seccion.nivel = PS.nivel;
                        // Ctrl.secciones[PS.seccion_id].nivel = PS.nivel;
                    });
                });
            };

            Ctrl.guardarPermisos = () => {
                $http.post('api/perfiles/guardar-permisos', {
                    'perfil_id': Ctrl.perfilSel.id,
                    'secciones': Ctrl.secciones
                });
            };
        }
    ]);
