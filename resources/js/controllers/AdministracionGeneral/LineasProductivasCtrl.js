angular.module('LineasProductivasCtrl', [])
    .controller('LineasProductivasCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog',
        function($scope, $rootScope, $http, $injector, $mdDialog) {

            var Ctrl = $scope;
            var Rs = $rootScope;

            Ctrl.LineasProductivasCRUD = $injector.get('CRUD').config({
                base_url: '/api/lineasproductivas/lineasproductivas',
                limit: 1000,
                add_append: 'refresh',
            });
            Ctrl.getLineasProductivas = () => {
                Ctrl.LineasProductivasCRUD.get().then(() => {});
                //Ctrl.nuevo();
            };

            Ctrl.getLineasProductivas();

            Ctrl.nuevo = () => {
                Ctrl.LineasProductivasCRUD.dialog({}, {
                    title: 'Agregar Linea Productiva'
                }).then(lp => {
                    Ctrl.LineasProductivasCRUD.add(lp)
                        .then(() => {
                            Rs.showToast('Linea productiva creada')
                        });
                });
            }

            Ctrl.editar = (LP) => {
                Ctrl.LineasProductivasCRUD.dialog(LP, {
                    title: 'Editar Linea Productiva ' + LP.nombre
                }).then(dato => {
                    if (dato == 'DELETE')
                        return Ctrl.LineasProductivasCRUD.delete(LP);
                    Ctrl.LineasProductivasCRUD.update(dato)
                        .then(() => {
                            Rs.showToast('Linea productiva actualizada')
                        });
                });
            };

            Ctrl.guardarLP = (LP) => {
                Ctrl.LineasProductivasCRUD.update(LP);
            }

            Ctrl.cargarImagen = async(LP) => {
                var Imagen = await $mdDialog.show({
                    templateUrl: 'templates/dialogs/image-editor.html',
                    controller: 'ImageEditor_DialogCtrl',
                    multiple: true,
                    locals: {
                        Config: {
                            Theme: 'default',
                            CanvasWidth: 200,
                            CanvasHeight: 200,
                            CropWidth: 200,
                            CropHeight: 200,
                            MinWidth: 50,
                            MinHeight: 50,
                            KeepAspect: true,
                            Preview: false,
                            Daten: {
                                Path: 'files/lineasproductivas_media/' + LP.id + '.jpg'
                            }
                        }
                    }
                });
            };
        }

    ]);