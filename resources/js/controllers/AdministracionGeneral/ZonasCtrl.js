angular.module("ZonasCtrl", []).controller("ZonasCtrl", [
    "$scope",
    "$rootScope",
    "$http",
    "$injector",
    "$mdDialog",
    function($scope, $rootScope, $http, $injector, $mdDialog) {
        var Ctrl = $scope;
        var Rs = $rootScope;

        Ctrl.Salir = $mdDialog.cancel;

        Ctrl.ZonasCRUD = $injector.get("CRUD").config({
            base_url: "/api/zonas/zonas",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            query_with:['linea_productiva']
        });

        Ctrl.getZona = () => {
            // Ctrl.ZonasCRUD.setScope('id', Rs.Usuario.Zona_id);
            Ctrl.ZonasCRUD.get().then(() => {
                Ctrl.Zona = Ctrl.ZonasCRUD.rows[0];
                //Ctrl.editarZona(Ctrl.ZonasCRUD.rows[0]);
                Ctrl.Zonascopy = Ctrl.ZonasCRUD.rows.slice();
            });
        };

        Ctrl.getZonas = () => {
            Ctrl.ZonasCRUD.get().then(() => {});
            //Ctrl.nuevo();
        };

        Ctrl.getZona();

        Ctrl.nuevaZona = () => {
            Ctrl.ZonasCRUD.dialog({
                Flex: 10,
                Title: "Crear Zona",
                Confirm: { Text: "Crear Zona" }
            }).then(r => {
                if (!r) return;
                Ctrl.ZonasCRUD.add(r);
                Rs.showToast('Zona Creada');
            });
        };

        Ctrl.editarZona = (Z) => {
			$mdDialog.show( {
				templateUrl: 'Frag/AdministracionGeneral.Zonas_ZonaEditorDiag',
				controller: 'Zonas_ZonaEditorCtrl',
				locals: { Zona: Z },
				scope: Ctrl.$new()
			});
		}


        // Ctrl.editarZona = Z => {
        //     Ctrl.ZonasCRUD.dialog(Z, {
        //         title: "Editar Zona" + Z.descripcion
        //     }).then(r => {
        //         if (r == "DELETE") return Ctrl.ZonasCRUD.delete(Z);
        //         Ctrl.ZonasCRUD.update(r).then(() => {
        //             Rs.showToast("Zona actualizada");
        //         });
        //     });
        // };

        Ctrl.eliminarZona = Z => {
            Rs.confirmDelete({
                Title: "¿Eliminar Zona #" + Z.id + "?"
            }).then(d => {
                if (!d) return;
                Ctrl.ZonasCRUD.delete(Z);
                Rs.showToast('Zona Eliminada');
            });
        };

        Ctrl.abrirOrganigrama = Z => {
            $mdDialog.show({
                templateUrl: "Frag/GestionZona.OrganigramaDiag",
                controller: "ZonaDiagCtrl",
                locals: { Zona: Z },
                fullscreen: false
            });
        };

        //INICIO DEV ANGÉLICA
        Ctrl.filterZona = () => {
            //Filtro de tipo de lote
            Ctrl.Zonascopy = Ctrl.ZonasCRUD.rows.slice(); //Cada que hagamos un filtro obtenemos los datos originales
           //Filtro para Descripcion
           if (Ctrl.filterDescripcion && Ctrl.filterDescripcion.length > 2){
            //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
            Ctrl.Zonascopy = Ctrl.Zonascopy.filter(Z => Z.descripcion.toUpperCase().indexOf(Ctrl.filterDescripcion.toUpperCase())> -1); //indexOf para mirar si una cadena está contenida en otra y me dice en que posición está contenida
           } 
           //Filtro para buscar Linea productiva
           if (Ctrl.filterLineaProductiva && Ctrl.filterLineaProductiva.length >= 1){
               //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
               Ctrl.Zonascopy = Ctrl.Zonascopy.filter(Z => Z.linea_productiva.nombre.toUpperCase().indexOf(Ctrl.filterLineaProductiva.toUpperCase())> -1);
           } 
        //FIN DEV ANGÉLICA
        }      
    }
]);
