angular.module("EventosCtrl", []).controller("EventosCtrl", [
    "$scope",
    "$rootScope",
    "$http",
    "$injector",
    "$mdDialog",
    function($scope, $rootScope, $http, $injector, $mdDialog) {

        var Ctrl = $scope;
        var Rs = $rootScope;
     
        Ctrl.Salir = $mdDialog.cancel;

        Ctrl.value = 0;

           Ctrl.EventosCRUD = $injector.get("CRUD").config({
            base_url: "/api/eventos/eventos",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            // query_with:['']
        });

        Ctrl.getEventos = () => {
            Ctrl.EventosCRUD.get().then(() => {
                Ctrl.Evento = Ctrl.EventosCRUD.rows[0];
                //Ctrl.editarLote(Ctrl.LotesCRUD.rows[0]);
            });
        };

        Ctrl.getEventos();

        Ctrl.nuevoEvento = () => {
            Ctrl.EventosCRUD.dialog({
                Flex: 10,
                Title: "Crear Evento",

                Confirm: { Text: "Crear Evento" }
            }).then(r => {
                if (!r) return;
                Ctrl.EventosCRUD.add(r);
                Rs.showToast('Evento Creado');
            });
        };
        Ctrl.editarEvento = E => {
            Ctrl.EventosCRUD.dialog(E, {
                title: "Editar Evento" + E.id
            }).then(r => {
                if (r == "DELETE") return Ctrl.EventosCRUD.delete(E);
                if (!r) return;
                Ctrl.EventosCRUD.update(r).then(() => {
                    Rs.showToast("Evento actualizado");
                });
            });
        };
        Ctrl.eliminarEvento = E => {
            Rs.confirmDelete({
                Title: "¿Eliminar Lote #" + E.id + "?"
            }).then(d => {
                if (!d) return;
                Ctrl.EventosCRUD.delete(E);
            });
        };
        Ctrl.cargarImagen = async(E) => {
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
                            Path: 'files/eventos_media/' + E.id + '.jpg'
                        }
                    }
                }
            });
        };

        // 
        Ctrl.FincaEventosCRUD = $injector.get("CRUD").config({
            base_url: "/api/eventos/eventos",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            // query_with:['finca', 'evento']
        });

        Ctrl.getFincaEventos = () => {
            Ctrl.FincaEventosCRUD.get().then(() => {
                Ctrl.FincaEvento = Ctrl.FincaEventosCRUD.rows[0];
                //Ctrl.editarLote(Ctrl.LotesCRUD.rows[0]);
            });
        };

        Ctrl.getFincaEventos();


    }
]);
