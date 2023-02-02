angular.module("CultivosCtrl", []).controller("CultivosCtrl", [
    "$scope",
    "$rootScope",
    "$http",
    "$injector",
    "$mdDialog",
    function($scope, $rootScope, $http, $injector, $mdDialog) {
        
        var Ctrl = $scope;
        var Rs = $rootScope;
        console.log("id_organizacion", Rs.Usuario.organizacion_id);
        Ctrl.zona_select = null;
        
        Ctrl.Salir = $mdDialog.cancel;

        Ctrl.value = 0;

         // Datos para informes estadisticos.

        // Promedio de Produccion.
        // Ctrl.promedioproduccion = 20;
        Ctrl.pp = () => {
            return $http.post('/api/organizaciones/promedioproduccion', {
                organizacion: Rs.Usuario.organizacion_id
            }).then( r => {
                console.log(r);
                bi = r.data[0];
                console.log(r);

                $scope.promedioproduccion = {
                    labels: ['Bim 1', 'Bim 2', 'Bim 3', 'Bim 4', 'Bim 5', 'Bim 6', 'PROY'],
                    data: [ bi.bimestre1, bi.bimestre2, bi.bimestre3, bi.bimestre4, bi.bimestre5, bi.bimestre6, 14.3],
                    backgroundColor: [
                        '#6b77be',
                        '#6b77be',
                        '#6b77be',
                        '#6b77be',
                        '#6b77be',
                        '#6b77be',
                        '#23d959'
                    ],
                };
                var ctx = document.getElementById('promedioproduccion').getContext('2d');
                var myCharBarras = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        datasets: [{
                            label: 'Promedio',
                            data: $scope.promedioproduccion.data,
                            backgroundColor: $scope.promedioproduccion.backgroundColor,
                            borderColor: [
                                'rgba(54, 162, 235, 1)'
                            ],
                            borderWidth: 1
                        }],
                        labels: $scope.promedioproduccion.labels,
                    },
                    options: {
                        scales: { y: { beginAtZero: true } },
                        plugins: {
                            title: {
                                display: true,
                                text: 'PROMEDIOS DE PRODUCCIÓN'
                            }
                        }
                    }
                });
            });
        };
        Ctrl.pp();


        // console.log('pro pro', Ctrl.promedioproduccion);
        //CRUD para recuperar los datos de usuario y Fincas
        Ctrl.FincasCRUD = $injector.get("CRUD").config({
            base_url: "/api/fincas/fincas",
            limit: 1000,
            add_append: "refresh",
            //order_by: ["-created_at"],
            query_scopes: [["organizacionusuario",Rs.Usuario.organizacion_id]],
            query_with: ["zonas", 'eventos', 'usuarios.organizaciones_usuario']
        });
        Ctrl.getFinca = () => {
            Ctrl.FincasCRUD.get().then(() => {
                Ctrl.Finca = Ctrl.FincasCRUD.rows[0];
                Ctrl.Fincascopy = Ctrl.FincasCRUD.rows.slice();
                console.log("FINCAS",Ctrl.FincasCRUD.rows);
                /*
                Ctrl.FincasCRUD.setScope("organizacion_id", Rs.Usuario.organizacion_id);
                Ctrl.Finca = Ctrl.FincasCRUD.rows[0];
                Ctrl.Fincascopy = Ctrl.FincasCRUD.rows.slice();
                console.log("FINCAS",Ctrl.FincasCRUD.rows);
                */
            });
            
        };
        Ctrl.getFinca();

        //Traer los usuarios de la organización
        Ctrl.UsuariosCRUD = $injector.get('CRUD').config({ 
			base_url: '/api/usuario/usuarios',
			//limit: 100,
			add_append: 'refresh',
			query_scopes: [["organizacionusuario",Rs.Usuario.organizacion_id]]
		});

        Ctrl.getUsuarios = () => {
            Ctrl.UsuariosCRUD.get().then(() => {
                Ctrl.Usuarios = Ctrl.UsuariosCRUD.rows.slice();
                //console.log("Usu_Orga",Ctrl.Usuarios );
            });
        }

        Ctrl.getUsuarios();
        
        //Fin traer los usuarios




        Ctrl.LotesCRUD = $injector.get("CRUD").config({
            base_url: "/api/lotes/lotes",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            query_with:['finca', 'organizacion', 'linea_productiva', 'labor']
        });

        Ctrl.getLotes = () => {
            Ctrl.LotesCRUD.setScope("organizacion_id", Rs.Usuario.organizacion_id);
            Ctrl.LotesCRUD.get().then(() => {
                Ctrl.Lote = Ctrl.LotesCRUD.rows[0];
                //Ctrl.editarLote(Ctrl.LotesCRUD.rows[0]);
                Ctrl.Lotes = Ctrl.LotesCRUD.rows.slice();
                console.log("Cultivos",Ctrl.Lote);
            });
        };

        Ctrl.getLotes();

        Ctrl.CultivosCRUD = $injector.get("CRUD").config({
            base_url: "/api/cultivos/cultivos",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            query_with:['zona', 'evento']
        });

        Ctrl.getCultivos = () => {
            Ctrl.CultivosCRUD.setScope('lazona', Ctrl.zona_select);  
            Ctrl.CultivosCRUD.get().then(() => {
                   
            });
           
        };

        Ctrl.nuevoCultivo = () => {
            Ctrl.CultivosCRUD.dialog({
                Flex: 10,
                Title: "Crear Cultivo",

                Confirm: { Text: "Crear Cultivo" }
            }).then(r => {
                if (!r) return;
                Ctrl.CultivosCRUD.add(r);
                Rs.showToast('Cultivo Creado');
            });
        };
        Ctrl.editarCultivo = C => {
            Ctrl.CultivosCRUD.dialog(C, {
                title: "Editar Cultivo" + C.id
            }).then(r => {
                if (r == "DELETE") return Ctrl.CultivosCRUD.delete(C);
                Ctrl.CultivosCRUD.update(r).then(() => {
                    Rs.showToast("Cultivo actualizado");
                });
            });
        };

        Ctrl.eliminarCultivo = C => {
            Rs.confirmDelete({
                Title: "¿Eliminar Cultivo #" + C.id + "?"
            }).then(d => {
                if (!d) return;
                Ctrl.CultivosCRUD.delete(C);
            });
        };

        Ctrl.obtener_zonas = () =>{
            return $http.post('api/zonas/obtener', {}).then(r => {
                Ctrl.zonas = r.data;
                Ctrl.zona_select = Ctrl.zonas[0].id;
                
            });
        }
        // 

        // 

        Promise.all([
            Ctrl.obtener_zonas()
        ]).then(() => {
            Ctrl.getCultivos();
        });



        // Cargar CRUD angular para Usuarios
        /*
        Ctrl.UsuariosCRUD = $injector.get('CRUD').config({
            base_url: '/api/usuario/usuarios',
            //limit: 100,
            add_append: 'refresh',
            query_with: ['perfil', 'organizaciones_usuario', 'fincas' , 'fincas.eventos']
        });
        
        Ctrl.getUsuarios = () => {
            //if ( Rs.Usuario.organizacion_id > 0 ) {
                Ctrl.UsuariosCRUD.setScope("laorganizacion", Rs.Usuario.organizacion_id); //Me trae las fincas del usuario
                Ctrl.UsuariosCRUD.get().then(() => {
                    console.log("usuarios dentro",Ctrl.UsuariosCRUD.rows);
                    Ctrl.Usuarioscopy = Ctrl.UsuariosCRUD.rows.slice();
                });

            //}
        };
        Ctrl.getUsuarios();
        console.log("usuarios",Ctrl.Usuarioscopy);
        */
       //Fin de carga de usuarios

        var listaMarcadores = [];
        var listaUsuarios = [];
        var listaAreas = [];
        var listaEventos = [];
        var map = new google.maps.Map(document.getElementById('dashboard'), {
            center: {lat: 4.852147911841803, lng: -75.5747982566813},
            mapTypeId: 'hybrid',
            zoom: 16,
            disableDefaultUI: false
        });
        Ctrl.dashboard = function(fincas, usuarios){

            if(fincas == undefined){
                return false;
            }

            $scope.map = map;
            
            const iconBase = "/imgs/";
            const icons = {
                finca: {
                icon: iconBase + "finca-icono.png",
                icon_productor : iconBase + "finca-icono-productor.png",
                icon_evento : "/files/eventos_media/"
                }
            };

            // Acá van los datos de las fincas Arhivo Datos_Elementos_Temporales_Mapa.txt
            
            const datosFincas = {};
            const datosEventos = {};
            const datosUsuarios = {};
            for(const finca in fincas){
                //console.log(fincas[finca].latitud);
                datosFincas[finca] = {
                    centro : {"lat":parseFloat(fincas[finca].latitud), "lng":parseFloat(fincas[finca].longitud)},
                    finca : fincas[finca].nombre,
                    nombre : fincas[finca].usuarios["nombre"],
                    area : fincas[finca].area_total
                };
                if(fincas[finca].eventos.length > 0){
                    datosEventos[finca] ={
                        centro : {"lat":parseFloat(fincas[finca].latitud), "lng":parseFloat(fincas[finca].longitud)},
                        observacion : fincas[finca].eventos[0].observacion,
                        tipo : fincas[finca].eventos[0].evento_id
                    };
                }
            }

            for(const usuario in usuarios){
                if(usuarios[usuario].nombres != undefined && usuarios[usuario].latitud != null && usuarios[usuario].longitud != null){
                    datosUsuarios[usuario] ={
                        centro : {"lat":parseFloat(usuarios[usuario].latitud), "lng":parseFloat(usuarios[usuario].longitud)},
                        nombre : usuarios[usuario].nombre
                    };
                }
            }

            console.log("datos usuario", datosUsuarios);

            // Acá van las areas de las fincas Arhivo Datos_Elementos_Temporales_Mapa.txt            

            var limites = new google.maps.LatLngBounds();
            var infoWindow = new google.maps.InfoWindow();
            
            for(const datoFinca in datosFincas){
                /*
                color = '#'+(Math.random() * 0xFFFFFF << 0).toString(16).padStart(6, '0');
                const circulo = new google.maps.Circle({
                    strokeColor: color,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: color,
                    fillOpacity: 0.45,
                    map,
                    center: datosFincas[datoFinca].centro,
                    radius: datosFincas[datoFinca].hectareas*100,
                  });
                */
                const markerFincas = new google.maps.Marker({position: datosFincas[datoFinca].centro, icon: icons["finca"].icon, map: map});
                limites.extend(datosFincas[datoFinca].centro);
                listaMarcadores.push(markerFincas);
                const infoMarker = `<div class="cuadro" style="display:table;padding: 10px;">
                                        <div style="display: table-cell;width:30%;vertical-align:middle;">
                                            <img src="/imgs/paco_isologo.png" width="150px" />
                                        </div>
                                        <div style="display: table-cell;width:70%;padding: 10px;vertical-align:middle;">
                                            <b>Finca:<b/> ` + datosFincas[datoFinca].finca + `<br/>
                                            <b>Asociado:</b> ` + datosFincas[datoFinca].nombre + `<br/>
                                            <b>Área:</b> ` + datosFincas[datoFinca].area + `Ha <br/>
                                        </div>
                                    </div>`;
                
                markerFincas.addListener("click", function() {
                    infoWindow.setContent(infoMarker);
                    infoWindow.open(map,markerFincas);
                });
                
            }

            for(const datoUsuario in datosUsuarios){
                const markerUsuarios = new google.maps.Marker({position: datosUsuarios[datoUsuario].centro, icon: icons["finca"].icon_productor, map: map});
                limites.extend(datosUsuarios[datoUsuario].centro);
                listaUsuarios.push(markerUsuarios);
                const infoMarker = `<div class="cuadro" style="display:table;padding: 10px;">
                                        <div style="display: table-cell;width:30%;vertical-align:middle;">
                                            <img src="/imgs/paco_isologo.png" width="150px" />
                                        </div>
                                        <div style="display: table-cell;width:70%;padding: 10px;vertical-align:middle;">
                                            <b>` + datosUsuarios[datoUsuario].nombre + `<b/>
                                        </div>
                                    </div>`;
                
                markerUsuarios.addListener("click", function() {
                    infoWindow.setContent(infoMarker);
                    infoWindow.open(map,markerUsuarios);
                });
                
            }

            //Ubicar el Mapa para que muestre todos los Marcadores
            map.fitBounds(limites);

            //Vienen los eventos
            for(const datoEvento in datosEventos){
                const markerEvento = new google.maps.Marker({position: datosEventos[datoEvento].centro, icon: icons["finca"].icon_evento + datosEventos[datoEvento].tipo + ".png", map: map});
                listaEventos.push(markerEvento);
                
            }

            //Construir todos los poligonos

            const areasFincas = {};
            for(const finca in Ctrl.Lotes){
                //console.log(finca,Ctrl.Lotes[finca].coordenadas);
                areasFincas[finca] = {
                    poligono : Ctrl.Lotes[finca].coordenadas
                };
            }
            console.log("coordenadas",areasFincas);
            
            for(const finca in areasFincas){
                color = '#'+(Math.random() * 0xFFFFFF << 0).toString(16).padStart(6, '0');
                var GClocation = new google.maps.Polygon({
                    paths: JSON.parse(areasFincas[finca].poligono),
                    strokeColor: color,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: color,
                    fillOpacity: 0.45,
                    });
                GClocation.setMap(map);
                listaAreas.push(GClocation);
            }
            

        }

        Ctrl.toggleMarcadores = () =>{
            var visible = document.getElementById("toggleMarcadores").checked;
            for(i=0;i < listaMarcadores.length;i++){
                visible ? listaMarcadores[i].setMap(map) : listaMarcadores[i].setMap(null);
            }
            //alert(listaMarcadores.length);
        }
        Ctrl.toggleUsuarios = () =>{
            var visible = document.getElementById("toggleUsuarios").checked;
            for(i=0;i < listaUsuarios.length;i++){
                visible ? listaUsuarios[i].setMap(map) : listaUsuarios[i].setMap(null);
            }
            //alert(listaMarcadores.length);
        }
        Ctrl.toggleAreas = () =>{
            var visible = document.getElementById("toggleAreas").checked;
            for(i=0;i < listaAreas.length;i++){
                visible ? listaAreas[i].setMap(map) : listaAreas[i].setMap(null);
            }
        }

        Ctrl.toggleEventos = () =>{
            var visible = document.getElementById("toggleEventos").checked;
            for(i=0;i < listaEventos.length;i++){
                visible ? listaEventos[i].setMap(map) : listaEventos[i].setMap(null);
            }
        }

        Ctrl.calcularPeriodo = () => {
            // console.log('hola a todos');
            $http.get('api/organizaciones/calculoproduccion/', {})
                .then();
                location.reload();
        };
        
	
}])
.directive("dashboard",[function(){
        return {
            restrict : "A",
            link : function($scope, element, attrs){
                $scope.$watch('Fincascopy', function(nuevo,viejo) {
                    if(nuevo != undefined){
                        $scope.dashboard(nuevo,$scope.Usuarios);
                    }
                });
            }
          };
    }]);
