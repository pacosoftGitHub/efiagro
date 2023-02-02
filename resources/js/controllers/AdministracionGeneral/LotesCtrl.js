angular.module("LotesCtrl", []).controller("LotesCtrl", [
    "$scope",
    "$rootScope",
    "$http",
    "$injector",
    "$mdDialog",
    function($scope, $rootScope, $http, $injector, $mdDialog) {
        var Ctrl = $scope;
        var Rs = $rootScope;


        Ctrl.filterFinca = "";
        Ctrl.filterOrganizacion = "";
        Ctrl.filterLineaProductiva = "";
       
        Ctrl.Salir = $mdDialog.cancel;

        Ctrl.LotesCRUD = $injector.get("CRUD").config({
            base_url: "/api/lotes/lotes",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            query_with:['finca', 'organizacion', 'linea_productiva', 'labor']
        });

        Ctrl.getLotes = () => {
            Ctrl.LotesCRUD.get().then(() => {
                Ctrl.Lote = Ctrl.LotesCRUD.rows[0];
                //Ctrl.editarLote(Ctrl.LotesCRUD.rows[0]);
                Ctrl.Lotescopy = Ctrl.LotesCRUD.rows.slice();
            });
        };

        Ctrl.getLotes();

        Ctrl.nuevoLote = () => {
            Ctrl.LotesCRUD.dialog({
                Flex: 10,
                Title: "Crear Lote",

                Confirm: { Text: "Crear Lote" }
            }).then(r => {
                if (!r) return;
                Ctrl.LotesCRUD.add(r);
                Rs.showToast('Lote Creado');
            });
        };

        Ctrl.editarLote = L => {
            Ctrl.LotesCRUD.dialog(L, {
                title: "Editar Lote" + L.id
            }).then(r => {
                if (r == "DELETE") return Ctrl.LotesCRUD.delete(L);
                if (!r) return;
                Ctrl.LotesCRUD.update(r).then(() => {
                    Rs.showToast("Lote actualizado");
                });
            });
        };

        Ctrl.eliminarLote = L => {
            Rs.confirmDelete({
                Title: "¿Eliminar Lote #" + L.id + "?"
            }).then(d => {
                if (!d) return;
                Ctrl.LotesCRUD.delete(L);
            });
        };

        // LABORES
        Ctrl.abrirLabores = L => {
            $mdDialog.show({
                templateUrl: "Frag/MiFinca.LaboresDiag",
                controller: "LaboresDiagCtrl",
                locals: { Labor: L },
                fullscreen: false
            });
        };

         //INICIO DEV ANGÉLICA
         Ctrl.filterLote = () => {
             //Filtro de tipo de lote
             Ctrl.Lotescopy = Ctrl.LotesCRUD.rows.slice(); //Cada que hagamos un filtro obtenemos los datos originales
             //Filtro para buscar Lote
             if (Ctrl.filterFinca && Ctrl.filterFinca.length > 2){
                 //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
                 Ctrl.Lotescopy = Ctrl.Lotescopy.filter(L => L.finca.nombre.toUpperCase().indexOf(Ctrl.filterFinca.toUpperCase())> -1);
            } 
            //Filtro para Organizacion
            if (Ctrl.filterOrganizacion && Ctrl.filterOrganizacion.length >= 1){
                //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
                Ctrl.Lotescopy = Ctrl.Lotescopy.filter(L => L.organizacion.nombre.toUpperCase().indexOf(Ctrl.filterOrganizacion.toUpperCase())> -1);
            }
                //Filtro para buscar Linea productiva
            if (Ctrl.filterLineaProductiva && Ctrl.filterLineaProductiva.length >= 1){
                //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
                Ctrl.Lotescopy = Ctrl.Lotescopy.filter(L => L.linea_productiva.nombre.toUpperCase().indexOf(Ctrl.filterLineaProductiva.toUpperCase())> -1);
            } 
        //FIN DEV ANGÉLICA
    }
        
    }
]);
