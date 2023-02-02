angular
    .module("FincasMifincaCtrl", [])
    .controller("FincasMifincaCtrl", [
        "$scope",
        "$rootScope",
        "$http",
        "$injector",
        "$mdDialog",
        function($scope, $rootScope, $http, $injector, $mdDialog) {

            var Ctrl = $scope;
            var Rs = $rootScope;


            //INICIO DEV ANGÉLICA
            var Departamentos = [];


            //Obtener el elemento de la lista
            Ctrl.getDepartamentos = () => {
                $http.post ('api/lista/obtener', { lista: 'Departamentos' }).then((r)=>{
                    Departamentos = r.data;
                    Ctrl.getFinca();
                });
            }

            Ctrl.getDepartamentos();

            Ctrl.FincasCRUD = $injector.get("CRUD").config({
                base_url: "/api/fincas/fincas",
                limit: 1000,
                add_append: "refresh",
                order_by: ["-created_at"],
                query_with: ["lotes"]
            });

            Ctrl.getFinca = () => {
                Ctrl.FincasCRUD.setScope("id", Rs.Usuario.finca_id); //Me trae las fincas del usuario
                Ctrl.FincasCRUD.get().then(() => {
                    Ctrl.Finca = Ctrl.FincasCRUD.rows[0];
                    //Ctrl.editarFinca(Ctrl.FincasCRUD.rows[0]);
                    if (Ctrl.Finca.departamento_id && Departamentos) {
                        Ctrl.Finca.nombreDepartamento = Departamentos[Ctrl.Finca.departamento_id];   
                        Ctrl.getMunicipio(Ctrl.Finca.municipio_id);                     
                    }
                    Ctrl.finca_coordenadas = { "longitud" : Ctrl.Finca.longitud , "latitud" :  Ctrl.Finca.latitud, "area" : Ctrl.Finca.area_total};
                    Ctrl.Lotes = Ctrl.Finca.lotes;
                    console.log("Coordenadas",Ctrl.finca_coordenadas);
                    console.log("Finca",Ctrl.Finca);
                });
            };

            //Ctrl.getFinca();


        //Obtener el elemento de la lista
        Ctrl.getMunicipio = (codigo) => {
			$http.post ('api/lista/obtenerdetalle', { lista_id: 3, codigo}).then((r)=>{
                Ctrl.Finca.nombreMunicipio = r.data.descripcion;
			});
		}
        //FIN DEV ANGELICA

        Ctrl.LotesCRUD = $injector.get("CRUD").config({
            base_url: "/api/lotes/lotes",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            query_with:['finca', 'organizacion', 'linea_productiva', 'labor']
        });
        Ctrl.getLotes = () => {
            Ctrl.LotesCRUD.setScope("finca_id", Rs.Usuario.finca_id); //Me trae los lotes de una finca
            Ctrl.LotesCRUD.get().then(() => {
                Ctrl.Lotes = Ctrl.LotesCRUD.rows;
                //Ctrl.editarLote(Ctrl.LotesCRUD.rows[0]);
                Ctrl.lotes = [];
                angular.forEach($scope.Lotes,function(valor, clave){
                    if(valor.coordenadas != undefined){
                        Ctrl.lotes.push(valor.coordenadas);
                    }
                });

            });
        };
        Ctrl.getLotes();
        
        Ctrl.crearMapa = function(lat_lons,coordenadas){

            if(lat_lons == undefined){
                return false;
            }

            var map = new google.maps.Map(document.getElementById('map'), {
                //center: {lat: 4.852147911841803, lng: -75.5747982566813},
                center: {lat : parseFloat(lat_lons.latitud), lng : parseFloat(lat_lons.longitud)},
                mapTypeId: 'hybrid',
                zoom: 16,
                disableDefaultUI: false
            });
        
            $scope.map = map;
            
            const iconBase = "/imgs/";
            const icons = {
                finca: {
                icon: iconBase + "finca-icono.png",
                }
            };
            const colores = ["#f00","#0f0","#00f"];
            
            var marker = new google.maps.Marker({position: {lat: parseFloat(lat_lons.latitud), lng: parseFloat(lat_lons.longitud)}, icon: icons["finca"].icon, map: map});
            // Define the LatLng coordinates for the polygon.
            const cityCircle = new google.maps.Circle({
                strokeColor: "#fff",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#fff",
                fillOpacity: 0.15,
                map,
                center: {lat: parseFloat(lat_lons.latitud), lng: parseFloat(lat_lons.longitud)},
                radius: parseFloat(lat_lons.area)*100
              });

              //Construit todos los poligonos

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
            }
        
            /*
            const GCCoords = [
                { "lat": 4.850726639851928  , "lng": -75.575134148821235  },
                { "lat": 4.850728400051594  , "lng": -75.575136328116059  },
                { "lat": 4.850811045616865  , "lng": -75.575285442173481  },
                { "lat": 4.850812889635563  , "lng": -75.575296422466636  },
                { "lat": 4.850881118327379  , "lng": -75.5754105001688  },
                { "lat": 4.850978180766106  , "lng": -75.575610073283315  },
                { "lat": 4.850978180766106  , "lng": -75.575612252578139  },
                { "lat": 4.851046409457922  , "lng": -75.575732868164778  },
                { "lat": 4.85116945579648  , "lng": -75.575770167633891  },
                { "lat": 4.851228799670935  , "lng": -75.575770167633891  },
                { "lat": 4.851261069998145  , "lng": -75.575794307515025  },
                { "lat": 4.851345559582114  , "lng": -75.575781147927046  },
                { "lat": 4.851345559582114  , "lng": -75.57578332722187  },
                { "lat": 4.851390486583114  , "lng": -75.575798666104674  },
                { "lat": 4.851440778002143  , "lng": -75.575864464044571  },
                { "lat": 4.851500038057566  , "lng": -75.575844682753086  },
                { "lat": 4.851552173495293  , "lng": -75.575772346928716  },
                { "lat": 4.851552173495293  , "lng": -75.575770167633891  },
                { "lat": 4.851584527641535  , "lng": -75.575730688869953  },
                { "lat": 4.851586287841201  , "lng": -75.575730688869953  },
                { "lat": 4.851634819060564  , "lng": -75.575737226754427  },
                { "lat": 4.851728277280927  , "lng": -75.575844682753086  },
                { "lat": 4.851789297536016  , "lng": -75.575824985280633  },
                { "lat": 4.851789297536016  , "lng": -75.575822805985808  },
                { "lat": 4.851827016100287  , "lng": -75.575792044401169  },
                { "lat": 4.851858532056212  , "lng": -75.575729599222541  },
                { "lat": 4.851858532056212  , "lng": -75.575720882043242  },
                { "lat": 4.85189801082015  , "lng": -75.57567042298615  },
                { "lat": 4.851973447948694  , "lng": -75.575600266456604  },
                { "lat": 4.8520543333143  , "lng": -75.575560787692666  },
                { "lat": 4.852109989151359  , "lng": -75.575538827106357  },
                { "lat": 4.852140583097935  , "lng": -75.575519045814872  },
                { "lat": 4.852224988862872  , "lng": -75.575424749404192  },
                { "lat": 4.852307634428144  , "lng": -75.575347971171141  },
                { "lat": 4.852307634428144  , "lng": -75.575345791876316  },
                { "lat": 4.852334624156356  , "lng": -75.575321651995182  },
                { "lat": 4.852334624156356  , "lng": -75.575242694467306  },
                { "lat": 4.852357925847173  , "lng": -75.57518133893609  },
                { "lat": 4.852453144267201  , "lng": -75.575168179348111  },
                { "lat": 4.85253126360476  , "lng": -75.575197767466307  },
                { "lat": 4.852599492296577  , "lng": -75.575215285643935  },
                { "lat": 4.852730669081211  , "lng": -75.575138507410884  },
                { "lat": 4.852797137573361  , "lng": -75.575048653408885  },
                { "lat": 4.852834856137633  , "lng": -75.574952093884349  },
                { "lat": 4.852834856137633  , "lng": -75.574949914589524  },
                { "lat": 4.852861845865846  , "lng": -75.574901634827256  },
                { "lat": 4.852901324629784  , "lng": -75.57485343888402  },
                { "lat": 4.852948011830449  , "lng": -75.574816139414907  },
                { "lat": 4.853025292977691  , "lng": -75.574800800532103  },
                { "lat": 4.853023532778025  , "lng": -75.574800800532103  },
                { "lat": 4.85317088663578  , "lng": -75.5747733078897  },
                { "lat": 4.85317088663578  , "lng": -75.574771128594875  },
                { "lat": 4.853284126147628  , "lng": -75.574760148301721  },
                { "lat": 4.853343386203051  , "lng": -75.574720669537783  },
                { "lat": 4.853370292112231  , "lng": -75.574714047834277  },
                { "lat": 4.853402646258473  , "lng": -75.574705330654979  },
                { "lat": 4.853363167494535  , "lng": -75.574657050892711  },
                { "lat": 4.853361323475838  , "lng": -75.574654871597886  },
                { "lat": 4.853298459202051  , "lng": -75.574582451954484  },
                { "lat": 4.853258896619082  , "lng": -75.574492514133453  },
                { "lat": 4.853226626291871  , "lng": -75.574389500543475  },
                { "lat": 4.853214053437114  , "lng": -75.574312722310424  },
                { "lat": 4.853212209418416  , "lng": -75.574312722310424  },
                { "lat": 4.853185303509235  , "lng": -75.574152627959847  },
                { "lat": 4.853199636563659  , "lng": -75.574034191668034  },
                { "lat": 4.853208689019084  , "lng": -75.573920197784901  },
                { "lat": 4.853208689019084  , "lng": -75.573762282729149  },
                { "lat": 4.853201564401388  , "lng": -75.573635045439005  },
                { "lat": 4.853215897455812  , "lng": -75.573582407087088  },
                { "lat": 4.852939210832119  , "lng": -75.57362406514585  },
                { "lat": 4.852757742628455  , "lng": -75.573689863085747  },
                { "lat": 4.852755982428789  , "lng": -75.573689863085747  },
                { "lat": 4.852480133995414  , "lng": -75.573856579139829  },
                { "lat": 4.852042766287923  , "lng": -75.574178947135806  },
                { "lat": 4.851759793236852  , "lng": -75.574416909366846  },
                { "lat": 4.851539684459567  , "lng": -75.574608854949474  },
                { "lat": 4.851218992844224  , "lng": -75.57467021048069  },
                { "lat": 4.851070884615183  , "lng": -75.57471077889204  },
                { "lat": 4.851068202406168  , "lng": -75.57471077889204  },
                { "lat": 4.850981952622533  , "lng": -75.574770038947463  },
                { "lat": 4.850979270413518  , "lng": -75.5747733078897  },
                { "lat": 4.850911879912019  , "lng": -75.574868693947792  },
                { "lat": 4.850728651508689  , "lng": -75.575131885707378 }
              ];
            const GClocation = new google.maps.Polygon({
                paths: GCCoords,
                strokeColor: "#a3e5b2",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#a3e5b2",
                fillOpacity: 0.45,
            });
            GClocation.setMap(map);

            poligono1 =  [{"lat":4.853414968, "lng":-75.574692},{"lat":4.853358977, "lng":-75.57458002},{"lat":4.853337016, "lng":-75.57445899},{"lat":4.853335004, "lng":-75.57445203},{"lat":4.853254035, "lng":-75.57426796},{"lat":4.853240037, "lng":-75.57416897},{"lat":4.853254035, "lng":-75.57406998},{"lat":4.853261998, "lng":-75.57396504},{"lat":4.853261998, "lng":-75.57393897},{"lat":4.853261998, "lng":-75.57392598},{"lat":4.853272978, "lng":-75.57379698},{"lat":4.853367023, "lng":-75.57364603},{"lat":4.853458973, "lng":-75.573541},{"lat":4.853499038, "lng":-75.57348199},{"lat":4.853553018, "lng":-75.57343204},{"lat":4.853556035, "lng":-75.57343204},{"lat":4.853590988, "lng":-75.57341896},{"lat":4.853592999, "lng":-75.57341896},{"lat":4.853606997, "lng":-75.57333698},{"lat":4.853606997, "lng":-75.57333296},{"lat":4.85357699, "lng":-75.57328401},{"lat":4.853573972, "lng":-75.57328099},{"lat":4.853542037, "lng":-75.57324797},{"lat":4.853580007, "lng":-75.57319198},{"lat":4.85357699, "lng":-75.57319198},{"lat":4.853766002, "lng":-75.57318502},{"lat":4.853901034, "lng":-75.57320204},{"lat":4.854134973, "lng":-75.57317203},{"lat":4.854263971, "lng":-75.573152},{"lat":4.854266988, "lng":-75.573152},{"lat":4.854395986, "lng":-75.57310598},{"lat":4.854456, "lng":-75.57313599},{"lat":4.854477039, "lng":-75.57322802},{"lat":4.854477039, "lng":-75.57323498},{"lat":4.85433396, "lng":-75.57346498},{"lat":4.85433396, "lng":-75.57346799},{"lat":4.854280986, "lng":-75.57370202},{"lat":4.854246033, "lng":-75.573771},{"lat":4.854232036, "lng":-75.57389597},{"lat":4.854213009, "lng":-75.57396504},{"lat":4.854150983, "lng":-75.57400804},{"lat":4.854104966, "lng":-75.57400804},{"lat":4.854070013, "lng":-75.57403796},{"lat":4.854070013, "lng":-75.57403402},{"lat":4.854046041, "lng":-75.57413},{"lat":4.854064984, "lng":-75.57424097},{"lat":4.854057021, "lng":-75.57430702},{"lat":4.854054004, "lng":-75.57431096},{"lat":4.854018968, "lng":-75.57436},{"lat":4.853864992, "lng":-75.57441004},{"lat":4.853800032, "lng":-75.57443703},{"lat":4.853745969, "lng":-75.57442697},{"lat":4.853629963, "lng":-75.57444298},{"lat":4.853571039, "lng":-75.57445002},{"lat":4.853548994, "lng":-75.57449897},{"lat":4.853557041, "lng":-75.57454901},{"lat":4.853500966, "lng":-75.57465403},{"lat":4.853416979, "lng":-75.57469703},{"lat":4.853416979, "lng":-75.57469301}];
            const GClocation2 = new google.maps.Polygon({
                paths: poligono1,
                strokeColor: "#ae7cbf",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#ae7cbf",
                fillOpacity: 0.45,
            });
            GClocation2.setMap(map);
           
            poligono2 = [{"lat":4.850510135, "lng":-75.57593026},{"lat":4.850553302, "lng":-75.5759259},{"lat":4.850556822, "lng":-75.57591928},{"lat":4.850599989, "lng":-75.57590612},{"lat":4.850599989, "lng":-75.57590394},{"lat":4.850648521, "lng":-75.57586446},{"lat":4.850716749, "lng":-75.57581183},{"lat":4.850776009, "lng":-75.57578769},{"lat":4.850776009, "lng":-75.57578551},{"lat":4.850826384, "lng":-75.57577679},{"lat":4.850894613, "lng":-75.57576137},{"lat":4.85096829, "lng":-75.57568023},{"lat":4.850979103, "lng":-75.57562323},{"lat":4.850979103, "lng":-75.57562105},{"lat":4.850948509, "lng":-75.57557059},{"lat":4.850948509, "lng":-75.57556842},{"lat":4.850907186, "lng":-75.57550044},{"lat":4.850905426, "lng":-75.57550044},{"lat":4.850869467, "lng":-75.57543238},{"lat":4.850806603, "lng":-75.57534026},{"lat":4.850774249, "lng":-75.5752613},{"lat":4.850731166, "lng":-75.57518897},{"lat":4.850731166, "lng":-75.57518679},{"lat":4.850691603, "lng":-75.57515167},{"lat":4.850621531, "lng":-75.57524378},{"lat":4.850553302, "lng":-75.57534688},{"lat":4.850553302, "lng":-75.57534906},{"lat":4.850501167, "lng":-75.5754302},{"lat":4.850497562, "lng":-75.5754302},{"lat":4.850467052, "lng":-75.57548502},{"lat":4.850465208, "lng":-75.57548502},{"lat":4.850409552, "lng":-75.5755794},{"lat":4.850409552, "lng":-75.57558157},{"lat":4.850441907, "lng":-75.57567805},{"lat":4.85046613, "lng":-75.57577679},{"lat":4.85046613, "lng":-75.57577897},{"lat":4.850480463, "lng":-75.5758513},{"lat":4.850482307, "lng":-75.57585348},{"lat":4.850511057, "lng":-75.5759347}];
            const GClocation3 = new google.maps.Polygon({
                paths: poligono2,
                strokeColor: "#e2e017",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#e2e017",
                fillOpacity: 0.45,
            });
            GClocation3.setMap(map);
            
            for(i=0; i < coordenadas.length; i++){
                if(coordenadas[i] == undefined || coordenadas[i] == ""){
                    continue;
                }
                const GCCoords = JSON.parse(coordenadas[i]);
                console.log(GCCoords);
                // Construct the polygon.
                const GClocation = new google.maps.Polygon({
                    paths: GCCoords,
                    strokeColor: colores[i],
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: colores[i],
                    fillOpacity: 0.45,
                });
                GClocation.setMap(map);
                
            }
            */
        }
        

        
    }])
    .directive("mapa",[function(){
        return {
            restrict : "A",
            link : function($scope, element, attrs){
                $scope.$watch('finca_coordenadas', function(nuevo,viejo) {
                    if(nuevo != undefined){
                        $scope.crearMapa(nuevo,$scope.lotes);
                    }
                });
            }
          };
    }]);
