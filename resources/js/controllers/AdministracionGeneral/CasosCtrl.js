angular.module("CasosCtrl", []).controller("CasosCtrl", [
    "$scope",
    "$rootScope",
    "$http",
    "$injector",
    "$mdDialog",
    function($scope, $rootScope, $http, $injector, $mdDialog) {
        var Ctrl = $scope;
        var Rs = $rootScope;

        var TiposCasos = [
            "Consulta General",
            "Apoyo Técnico",
            "Contar Experiencia"
        ];

        Ctrl.tiposCasos = TiposCasos;
        Ctrl.filterTipo = "";
        Ctrl.filterAsociado = "";
        Ctrl.filterLlevacaso = "";

        Ctrl.CasosCRUD = $injector.get("CRUD").config({
            base_url: "/api/casos/casos",
            limit: 1000,
            add_append: "refresh",
            query_with: ["solicitante"],
            order_by: ["-created_at"]
        });
        //Inicio Dev Angélica
        Ctrl.CasosCRUD.setScope("tipo");
        //Fin Dev Angélica

        Ctrl.UsuariosCRUD = $injector
            .get("CRUD")
            .config({ base_url: "/api/usuario/usuarios" });

        Ctrl.getCasos = () => {
            Promise.all([Ctrl.UsuariosCRUD.get()]).then(() => {
                Ctrl.CasosCRUD.get().then(() => {
                	Ctrl.Casoscopy = Ctrl.CasosCRUD.rows.slice();
                });
            });
        };

        Ctrl.getCasos();

        Ctrl.nuevoCaso = () => {
            Rs.BasicDialog({
                Flex: 30,
                Title: "Crear Nuevo Caso",
                Fields: [
                    {
                        Nombre: "Asociado",
                        Value: null,
                        Type: "list",
                        List: Ctrl.UsuariosCRUD.rows,
                        Required: false,
                        Item_Val: "id",
                        Item_Show: "nombres"
                    },
                    {
                        Nombre: "Tipo de Caso",
                        Value: TiposCasos[0],
                        Type: "simplelist",
                        List: TiposCasos,
                        Required: true
                    },
                    {
                        Nombre: "Describe el Caso",
                        Value: "",
                        Type: "textarea",
                        Required: true,
                        opts: { rows: 3 }
                    }
                ],
                Confirm: { Text: "Crear Caso" }
            }).then(r => {
                if (!r) return;

                var NuevoCaso = {
                    titulo: r.Fields[2].Value,
                    solicitante_id: r.Fields[0].Value,
                    tipo: r.Fields[1].Value,
                    asignados: "[]"
                };

                Ctrl.CasosCRUD.add(NuevoCaso);
            });
        };

        Ctrl.editarCaso = C => {
            Rs.BasicDialog({
                Flex: 30,
                Title: "Crear Nuevo Caso",
                Fields: [
                    {
                        Nombre: "Asociado",
                        Value: C.solicitante_id,
                        Type: "list",
                        List: Ctrl.UsuariosCRUD.rows,
                        Required: false,
                        Item_Val: "id",
                        Item_Show: "nombres"
                    },
                    {
                        Nombre: "Tipo de Caso",
                        Value: C.tipo,
                        Type: "simplelist",
                        List: TiposCasos,
                        Required: true
                    },
                    {
                        Nombre: "Describe el Caso",
                        Value: C.titulo,
                        Type: "textarea",
                        Required: true,
                        opts: { rows: 3 }
                    }
                ],
                Confirm: { Text: "Crear Caso" }
            }).then(r => {
                if (!r) return;

                var CasoEditado = {
                    id: C.id,
                    titulo: r.Fields[2].Value,
                    solicitante_id: r.Fields[0].Value,
                    tipo: r.Fields[1].Value,
                    asignados: "[]"
                };

                Ctrl.CasosCRUD.update(CasoEditado).then(() => {
                    Ctrl.CasosCRUD.get();
                    Rs.showToast("Caso actualizado");
                });
            });
        };

        Ctrl.eliminarCaso = C => {
            Rs.confirmDelete({
                Title: "¿Eliminar el caso #" + C.id + "?"
            }).then(d => {
                if (!d) return;
                Ctrl.CasosCRUD.delete(C);
            });
        };

        // Inicia codigo Luigi
        Ctrl.novedadesCaso = C => {
            $mdDialog.show({
                templateUrl: "Frag/AdministracionGeneral.Casos_NovedadesDiag",
                controller: "Casos_NovedadesCtrl",
                locals: {
                    Caso: C
                }
            });
        };
        // Finaliza codigo Luigi

        //INICIO DEV ANGÉLICA
        Ctrl.filterCaso = () => {
            //Filtro de tipo de caso
			Ctrl.Casoscopy = Ctrl.CasosCRUD.rows.slice(); //Cada que hagamos un filtro obtenemos los datos originales
			if (Ctrl.filterTipo && Ctrl.filterTipo.length > 0){ //quiero que se haya digitado alguna cosa en el campo
				Ctrl.Casoscopy = Ctrl.Casoscopy.filter(caso => caso.tipo === Ctrl.filterTipo);
			}
            //Filtro para asociado
			if (Ctrl.filterAsociado && Ctrl.filterAsociado.length > 2){
				//toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
				Ctrl.Casoscopy = Ctrl.Casoscopy.filter(caso => caso.solicitante.nombre.toUpperCase().indexOf(Ctrl.filterAsociado.toUpperCase())> -1); //indexOf para mirar si una cadena está contenida en otra y me dice en que posición está contenida
			}
            //Filtro para quien lleva el caso
            debugger;
			if (Ctrl.filterLlevacaso && Ctrl.filterLlevacaso.length > 2){
				//toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
				Ctrl.Casoscopy = Ctrl.Casoscopy.filter(caso => caso.asignados.nombre.toUpperCase().indexOf(Ctrl.filterLlevacaso.toUpperCase())> -1); //indexOf para mirar si una cadena está contenida en otra y me dice en que posición está contenida
			}
        } //FIN DEV ANGÉLICA
    }
]);
