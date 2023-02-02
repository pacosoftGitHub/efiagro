// Inicio del codigo de Luigi
angular.module('Casos_NovedadesCtrl', [])
    .controller('Casos_NovedadesCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Caso',
        function($scope, $rootScope, $http, $injector, $mdDialog, Caso) {

            // Creamos y asignamos la variables Ctrl y scope
            var Ctrl = $scope;
            var Rs = $rootScope;
            Ctrl.Cancel = $mdDialog.cancel;

            // Creamos copia de Caso
            Ctrl.Caso = angular.copy(Caso);

            // Obtenemos los datos de novedades por caso, en NovedaesCRUD
            Ctrl.NovedadesCRUD = $injector.get('CRUD').config({
                base_url: '/api/casos/novedades',
                limit: 1000,
                add_append: 'refresh',
                query_with: ["autor"]
            });

            // Creamos listado de Tipo de novedad
            Ctrl.TipoNovedad = {
                'Parrafo': { Nombre: 'Parrafo', icono: 'fa-align-justify' },
                'Imagen': { Nombre: 'Imagen', icono: 'fa-image' }
            }

            // Obtenemos la infromación de un caso especifico con el ID
            Ctrl.getNovedades = () => {
                Ctrl.NovedadesCRUD.setScope('elcaso', Caso.id).get();
            }

            Ctrl.getNovedades();

            Ctrl.guardarCaso = () => {
                Ctrl.CasosCRUD.update(Ctrl.Caso);
            };

            // Evento para el registro de la novedad en un caso específico.
            Ctrl.crearNovedad = async(tipo, contenido) => {
                var novedad = contenido;
                if (tipo == 'Imagen') {
                    var Imagen = await $mdDialog.show({
                        templateUrl: 'templates/dialogs/image-editor.html',
                        controller: 'ImageEditor_DialogCtrl',
                        multiple: true,
                        locals: {
                            Config: {
                                Theme: 'default',
                                CanvasWidth: 600,
                                CanvasHeight: 400,
                                CropWidth: 600,
                                CropHeight: 400,
                                MinWidth: 60,
                                MinHeight: 40,
                                KeepAspect: true,
                                Preview: false,
                                Daten: {
                                    Path: 'files/casos_media/' + Caso.id + '/' + moment().format('YYYYMMDDHHmmss') + '.jpg'
                                }
                            }
                        }
                    });
                    novedad = Imagen.Msg;
                }
                if (tipo == 'Texto') {
                    Ctrl.detallecaso = '';
                }
                Ctrl.NovedadesCRUD.add({
                    caso_id: Caso.id,
                    tipo: tipo,
                    novedad: novedad,
                    usuario_id: Rs.Usuario.id
                });
            };

        }
    ]);
// Fin del codigo de Luigi
