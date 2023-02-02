angular.module("FincaEventosCtrl", []).controller("FincaEventosCtrl", [
    "$scope",
    "$rootScope",
    "$http",
    "$injector",
    "$mdDialog",
    function($scope, $rootScope, $http, $injector, $mdDialog) {
    console.log('Este es Finca Eventos');
    
        var Ctrl = $scope;
        var Rs = $rootScope;

        console.log("ID Usuario", Rs.Usuario.id);

        Ctrl.filterFinca = "";
        Ctrl.filterEvento = "";
     
        Ctrl.Salir = $mdDialog.cancel;

        Ctrl.value = 0;
        Ctrl.FincaEventosCRUD = $injector.get("CRUD").config({
            base_url: "/api/fincaeventos/fincaeventos",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            query_with:['finca', 'evento']
        });

        Ctrl.getFincaEventos = () => {
            //Ctrl.FincaEventosCRUD.setScope("usuario",Rs.Usuario.finca_id);
            Ctrl.FincaEventosCRUD.get().then(() => {
                Ctrl.FincaEvento = Ctrl.FincaEventosCRUD.rows[0];
                //Ctrl.editarLote(Ctrl.LotesCRUD.rows[0]);
                Ctrl.FincaEventoscopy = Ctrl.FincaEventosCRUD.rows.slice();
            });
        };

        Ctrl.getFincaEventos();

        Ctrl.nuevoEvento = () => {
            Ctrl.FincaEventosCRUD.dialog({usuario_id : Rs.Usuario.id},{
                Flex: 10,
                Title: "Crear Evento",

                Confirm: { Text: "Crear Evento" }
            }).then(r => {
                if (!r) return;
                Ctrl.FincaEventosCRUD.add(r);
                Rs.showToast('Evento Creado');
            });
        };
        Ctrl.editarEvento = FE => {
            Ctrl.FincaEventosCRUD.dialog(FE, {
                title: "Editar Evento" + FE.id
            }).then(r => {
                if (r == "DELETE") return Ctrl.FincaEventosCRUD.delete(FE);
                if (!r) return;
                Ctrl.FincaEventosCRUD.update(r).then(() => {
                    Rs.showToast("Evento actualizado");
                });
            });
        };
        Ctrl.eliminarEvento = FE => {
            Rs.confirmDelete({
                Title: "¿Eliminar Lote #" + FE.id + "?"
            }).then(d => {
                if (!d) return;
                Ctrl.FincaEventosCRUD.delete(FE);
            });
        };
        Ctrl.cargarImagen = async(FE) => {
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
                            Path: 'files/eventos_media/' + FE.id + '.jpg'
                        }
                    }
                }
            });
        };
        //INICIO DEV ANGÉLICA
        Ctrl.filterFincaEvento = () => {
            //Filtro para finca
            if (Ctrl.filterFinca && Ctrl.filterFinca.length > 1){
                //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
                Ctrl.FincaEventoscopy = Ctrl.FincaEventoscopy.filter(FE => FE.finca.nombre.toUpperCase().indexOf(Ctrl.filterFinca.toUpperCase())> -1); //indexOf para mirar si una cadena está contenida en otra y me dice en que posición está contenida
            }
            
            //Filtro para buscar Evento
            if (Ctrl.filterEvento && Ctrl.filterEvento.length > 1){
                //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
                Ctrl.FincaEventoscopy = Ctrl.FincaEventoscopy.filter(FE => FE.evento.evento.toUpperCase().indexOf(Ctrl.filterEvento.toUpperCase())> -1); //indexOf para mirar si una cadena está contenida en otra y me dice en que posición está contenida
            }
        } 
        //FIN DEV ANGÉLICA
    }
]);
