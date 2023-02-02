angular.module("LaboresCtrl", []).controller("LaboresCtrl", [
    "$scope",
    "$rootScope",
    "$http",
    "$injector",
    "$mdDialog",
    function($scope, $rootScope, $http, $injector, $mdDialog) {

        var Ctrl = $scope;
        var Rs = $rootScope;
        

        Ctrl.zona_select = null;
        Ctrl.linea_lp_select = null;

        Ctrl.Salir = $mdDialog.cancel;

        Ctrl.value = 0;

        Ctrl.LaboresCRUD = $injector.get("CRUD").config({
            base_url: "/api/labores/labores",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            query_with:['linea_productiva', 'zona']
        });


        Ctrl.getLabores = () => {
            Ctrl.LaboresCRUD.setScope('lazona', Ctrl.zona_select);
            Ctrl.LaboresCRUD.setScope('lalineaproductiva', Ctrl.linea_lp_select);
            
            Ctrl.LaboresCRUD.get().then(() => {
                               
            });
            // console.log(Ctrl.linea_lp_select.nombre);
        };

Ctrl.nuevaLabor = () => {
    Rs.BasicDialog({
        Flex: 30,
        Title: "Crear Labor",
        Fields: [
            
            {
                Nombre: "Labor",
                Value: "",
                Type: "string",
                Required: true
            },
            {
                Nombre: "Zona",
                Value: Ctrl.zona_select,
                Type: "list",
                List: Ctrl.zonas, Item_Val:'id', Item_Show:'descripcion',
                Required: true
            },
            {
                Nombre: "Linea Productiva",
                Value: Ctrl.linea_lp_select,
                Type: "list",
                List: Ctrl.lineas_productivas, Item_Val:'id', Item_Show:'nombre', 
                Required: true
            },
            {
                Nombre: "Frecuencia",
                Value: "",
                Type: "string",
                Required: true
            },
            {
                Nombre: "Semana Inicio",
                Value: "",
                Type: "string",
                Required: true
            },
            {
                Nombre: "Margen",
                Value: "",
                Type: "string",
                Required: true
            }
        ],

        Confirm: { Text: "Crear Labor" }
    }).then(r => {
        if (!r) return;
        var nuevaLabor = {
            labor : r.Fields[0].Value,
            zona_id: r.Fields[1].Value,
            linea_productiva_id: r.Fields[2].Value,
            frecuencia: r.Fields[3].Value,
            inicio: r.Fields[4].Value,
            margen: r.Fields[5].Value,
            

        };
        Ctrl.LaboresCRUD.add(nuevaLabor);
    });
};
        
        Ctrl.editarLabor = (L) => {
			$mdDialog.show( { 
				templateUrl: 'Frag/AdministracionGeneral.Labores_LaborEditorDiag',
				controller: 'Labores_LaborEditorCtrl',
				locals: { Labor: L },
				scope: Ctrl.$new()
			});
		}
        
        Ctrl.eliminarLabor = L => {
            Rs.confirmDelete({
                Title: "¿Eliminar Labor #" + L.id + "?"
            }).then(d => {
                if (!d) return;
                Ctrl.LaboresCRUD.delete(L);
            });
        };
        
        Ctrl.obtener_lp = () =>{
            return $http.post('api/lineasproductivas/obtener', {}).then(r => {
                Ctrl.lineas_productivas = r.data;
                Ctrl.linea_lp_select = Ctrl.lineas_productivas[0].id;
                
            });

        }
        Ctrl.obtener_zonas = ()=>{
            return $http.post('api/zonas/obtener', {}).then(r => {
                Ctrl.zonas = r.data;
                Ctrl.zona_select = Ctrl.zonas[0].id;
                
            });
        }

        Promise.all([
            Ctrl.obtener_lp(),
            Ctrl.obtener_zonas()
        ]).then(() => {
            Ctrl.getLabores();
        });
    }
]);
