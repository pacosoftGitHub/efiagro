angular.module('MiTecnicoAmigoCtrl', [])
    .controller('MiTecnicoAmigoCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', '$state',
        function($scope, $rootScope, $http, $injector, $mdDialog, $state) {
            var Ctrl = $scope;
            var Rs = $rootScope;

            // Por defecto carga la subseccion Inicio (MiTecnicoAmigo) :: Luigi
            Ctrl.Subseccion = 'Inicio';
            Ctrl.PalabrasClave = [];
            Ctrl.Cancel = $mdDialog.cancel;
             //INICIO DEV ANGELICA
             Ctrl.SelectedKey = false;
             Ctrl.key = "";
             Ctrl.keys= [];
             Ctrl.ArticulosBuscados = [];
             Ctrl.ArticulosLinea = [];
             Ctrl.LineasProductivasUsuario = [];

             // Cargar los lotes de la finca seleccionada
            Ctrl.cargarLineasProductivasUsuario = () => {
                loteSeleccionado = 0;
                lineaSeleccionada = 0;
                $http.post('api/lotes/lineaproductivausuario', { 
                    usuario: Rs.Usuario.id
                }).then(res => {
                    console.log(res.data);
                    res.data.forEach(function(lp) {
                        Ctrl.LineasProductivasUsuario.push(lp.linea_productiva_id);
                    });
                });
            };

            Ctrl.cargarLineasProductivasUsuario();

            Ctrl.getOpciones = () => {
                Rs.http('/api/opciones', {}, Ctrl, 'Opciones');
                //let opciones =  Rs.http('/api/opciones', {});
                //console.log(opciones);
            }

            Ctrl.getOpciones()


            $http.post('api/articulos/obtener', {}).then(
                r => {
                    Ctrl.Articulos = r.data;
                    //Inicio Dev Angélica -- seleccionar las palabras claves
                    let keys = [];
                    Ctrl.Articulos.forEach(function(articulo) {
                        if (Ctrl.LineasProductivasUsuario.indexOf(articulo.linea_productiva_id) >=0) {
                            Ctrl.ArticulosLinea.push(articulo);
                        }
                        if (articulo.palabras_clave && articulo.palabras_clave.length > 3) {
                            keys.push(...articulo.palabras_clave.split(","));
                        }
                    });
                    console.log(Ctrl.ArticulosLinea);
                    keys = keys.sort().filter(function(item, pos, ary) {
                        return !pos || item != ary[pos - 1];
                    });
                    // console.log(keys);
                    Ctrl.PalabrasClave = keys;
                });
            //Fin Dev Angélica 


            Ctrl.abrirArticulo = (A) => {
                $mdDialog.show({
                    templateUrl: 'Frag/MiTecnicoAmigo.ArticuloDiag',
                    controller: 'ArticuloDiagCtrl',
                    locals: { Articulo: A },
                    fullscreen: false,
                });
            };

            //Casos :: Inicia Luigi
            // Obtener toda la información y metodos de CASOS
            Ctrl.CasosCRUD = $injector.get('CRUD').config({
                base_url: '/api/casos/casos',
                limit: 1000,
                add_append: 'refresh',
                query_with: ['novedades', 'solicitante'],
                order_by: []
            });

            Ctrl.getCasos = () => {
                //Inicio Dev Angélica
                //Filtra el tipo (sólo muestra los casos que deben aparecer en pantalla)-->'Consulta General', 'Apoyo Tecnico', 'Contar Experiencia' [ver archivo Caso.php]
                Ctrl.CasosCRUD.setScope('tipo');
                Ctrl.CasosCRUD.get();
                //Fin Dev Angélica
            }
            Ctrl.getCasos();
            //Casos :: Finaliza Luigi

            Ctrl.crearCaso = (opcion) => {

                if(opcion == 1){
                    var OpcionesTipo = [
                        ['Quiero Contar Una Experiencia', 'Contar Experiencia']
                    ];
                    var opcion = { Nombre: '¿En Qué Puedo Ayudarte?', Value: 'Quiero Contar Una Experiencia', Type: 'simplelist', List: OpcionesTipo.map(a => a[0]), Required: true };
                }else{
                    var OpcionesTipo = [
                        ['Tengo una Duda General', 'Consulta General'],
                        ['Necesito Ayuda Técnica', 'Apoyo Técnico'],
                        ['Quiero Contar Una Experiencia', 'Contar Experiencia']
                    ];
                    var opcion = { Nombre: '¿En Qué Puedo Ayudarte?', Value: 'Tengo una Duda General', Type: 'simplelist', List: OpcionesTipo.map(a => a[0]), Required: true };
                }

                Rs.BasicDialog({
                    Flex: 30,
                    Title: 'Crear Nueva Solicitud',
                    Fields: [
                        //{ Nombre: '¿En Qué Puedo Ayudarte?', Value: 'Tengo una Duda General', Type: 'simplelist', List: OpcionesTipo.map(a => a[0]), Required: true },
                        opcion,
                        { Nombre: 'Describe el Caso', Value: '', Type: 'textarea', Required: true, opts: { rows: 3 } }
                    ],
                    Confirm: { Text: 'Crear Solicitud' },
                }).then(r => {
                    if (!r) return;

                    var NuevoCaso = {
                        titulo: r.Fields[1].Value,
                        solicitante_id: Rs.Usuario.id,
                        tipo: 'Contar Experiencia',
                        asignados: '[]'
                    };
                    Ctrl.CasosCRUD.add(NuevoCaso);
                    Ctrl.navegarA('Solicitudes');
                });
            };

            //INICIO DEV ANGÉLICA
            Ctrl.crearCasoTelefonico = (medio) => {
                var NuevoCaso = {
                    titulo: 'Boton Contacto',
                    solicitante_id: Rs.Usuario.id,
                    tipo: medio,
                    asignados: '[]'
                };
                alert('Inicia llamado al WS')
                Ctrl.CasosCRUD.add(NuevoCaso);
            };
            //FIN DEV ANGELICA

            // Novedad Caso :: Inicia Luigi
            // Abrir el modal para la revisión y creación de novedades por Caso
            Ctrl.novedadesCaso = (C) => {
                $mdDialog.show({
                    templateUrl: 'Frag/MiTecnicoAmigo.MiTecnicoAmigo_SolicitudesDetalleDiag',
                    controller: 'SolicitudesDetalleCtrl',
                    locals: {
                        Caso: C
                    },
                });
            };
            // Novedad Caso :: Finaliza Luigi

            //INICIO DEV ANGÉLICA ---> Filtro de búsqueda 
            Ctrl.suppressSpecialCharacters = (word) => { // funcion para buscar con tiltes
                return word.toLowerCase().replace(" de ", " ")
                .replace(" en ", " ")
                .replace(" para ", " ")
                .replace(" por ", " ")
                .replace(" la ", " ")
                .replace("é", "e")
                .replace("á", "a")
                .replace("í", "i")
                .replace("ó", "o")
                .replace("ú", "u")
                .replace(" y ", " ");
            }
            Ctrl.searchChange = function() {
                let filtro = Ctrl.filtroArticulos;
                if (!filtro) return Ctrl.Buscando = false;
                filtro = Ctrl.suppressSpecialCharacters(filtro);

                if (filtro == "") return Ctrl.Buscando = false;
                let keys = filtro.toLowerCase().split(" ");
                Ctrl.keys = [];//nuevo
                var ArticulosBuscados = [];
                Ctrl.Buscando = true;
                Ctrl.Articulos.forEach(function(articulo) {
                    articulo.contador = 0;
                    keys.forEach(function(key) {
                        if (Ctrl.suppressSpecialCharacters(articulo.titulo.toLowerCase()).indexOf(key) >= 0) {
                            articulo.contador++;
                        }
                    });
                    // Recorre cada una de las palabras digitadas en el filtro
                    keys.forEach(function (palabra){
                        // Separa cada una de las pabras clave del artuculo
                        let keys = articulo.palabras_clave && articulo.palabras_clave.toLowerCase().split(",");
                        // Buscamos si la palabra del filtro esta en la lista de palabras clave
                        if (keys && keys.includes(palabra)) {
                            articulo.contador++; 
                            Ctrl.SelectedKey = true;
                            Ctrl.keys.push(palabra);
                        }
                    });                    
                    if (articulo.contador > 0) ArticulosBuscados.push(articulo);
                });
                Ctrl.ArticulosBuscados = ArticulosBuscados;
            };
            //FIN DEV ANGÉLICA

            //INICIO DEV ANGÉLICA -- Search key words
            Ctrl.searchKeyWords = (key) => {
                var ArticulosBuscados = [];
                Ctrl.Buscando = true;
                Ctrl.SelectedKey = true;
                Ctrl.key = key;
                Ctrl.Articulos.forEach(function(articulo) {
                    articulo.contador = 0;
                    if (articulo.palabras_clave && articulo.palabras_clave.indexOf(key) >= 0) {
                        articulo.contador++;
                    }
                    if (articulo.contador > 0) ArticulosBuscados.push(articulo);
                });
                Ctrl.ArticulosBuscados = ArticulosBuscados;
            };

            Ctrl.cleanFilter = () => {
                Ctrl.SelectedKey = false;
                Ctrl.key = "";
                Ctrl.Buscando = false;
                Ctrl.ArticulosBuscados = [];
                Ctrl.keys = [];
            };

            //FIN DEV ANGÉLICA

            // Navegar :: Inicia Luigi
            // Metodo para navegar en opciones de Mi Tecnico Amigo
            Ctrl.navegarA = (s) => {
                $state.go('Home.Seccion.Subseccion', { subseccion: s });
            };
            // Navegar :: Finaliza Luigi

            if(document.getElementById("paco") != undefined){
                imagenes = ["paco1.png","paco2.png","paco3.png"];
                //alert(Math.ceil(Math.random()*3)-1);
                document.getElementById("paco").src = "imgs/" + imagenes[Math.ceil(Math.random()*3)-1];
            }
            
        }
    ]);
