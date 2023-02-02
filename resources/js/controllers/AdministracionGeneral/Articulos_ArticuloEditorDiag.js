//const { cloneDeep } = require("lodash");

angular.module('Articulos_ArticuloEditorCtrl', [])
    .controller('Articulos_ArticuloEditorCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Articulo',
        function($scope, $rootScope, $http, $injector, $mdDialog, Articulo) {

            var Ctrl = $scope;
            var Rs = $rootScope;

            //INICIO DEV ANGÉLICA -- Lists of palabras clave en chips 
            Ctrl.keyWords = [];
            //FIN DEV ANGÉLICA

            Ctrl.Cancel = $mdDialog.cancel;

            Ctrl.Articulo = angular.copy(Articulo);
            //INICIO DEV ANGÉLICA -- Lists of palabras clave en chips 
            if(Ctrl.Articulo.palabras_clave){
                Ctrl.keyWords = Ctrl.Articulo.palabras_clave.split(",");
            }else{
                Ctrl.keyWords = [];
            }
            //FIN DEV ANGÉLICA

            //INCIO DEV ANGÉLICA --> Lineas productivas
		    $http.post('api/lineasproductivas/obtener', {}).then(r => {
			Ctrl.lineas_productivas = r.data;
		
		    });
		    //FIN DEV ANGÉLICA

            Ctrl.SeccionesCRUD = $injector.get('CRUD').config({
                base_url: '/api/articulos/secciones',
                limit: 1000,
                add_append: 'refresh',
            });

            Ctrl.TiposSeccion = {
                'Parrafo': { Nombre: 'Párrafo', Icono: 'fa-align-justify' },
                'Tabla': { Nombre: 'Tabla', Icono: 'fa-table' },
                'Imagen': { Nombre: 'Imágen', Icono: 'fa-image' }
            };

            Ctrl.getSecciones = () => {
                Ctrl.SeccionesCRUD.setScope('elarticulo', Articulo.id).get();
            };

            Ctrl.getSecciones();

            Ctrl.guardarArticulo = () => {
                //INICIO DEV ANGELICA -- Actualización de palabras clave en chips
                Ctrl.Articulo.palabras_clave = Ctrl.keyWords.join();
                Ctrl.$parent.ArticulosCRUD.update(Ctrl.Articulo).then(() => {
                    var SeccionesCambiadas = Ctrl.SeccionesCRUD.rows.filter(S => S.changed);
                    if (SeccionesCambiadas.length > 0) {
                        Ctrl.SeccionesCRUD.updateMultiple(SeccionesCambiadas).then(() => {
                        });
                    }
                });
            }

            Ctrl.crearSeccion = async(kT) => {

                var ruta = null;
                var contenido = null;
                // Luigi :: Obtener el numero de secciones e incrementar en uno, para el indice.
                var indice = Ctrl.SeccionesCRUD.rows.length + 1;

                if (kT == 'Imagen') {
                    var Img = await $mdDialog.show({
                        templateUrl: 'templates/dialogs/image-editor.html',
                        controller: 'ImageEditor_DialogCtrl',
                        multiple: true,
                        locals: {
                            Config: {
                                Theme: 'default',
                                CanvasWidth: 600, //Ancho del canvas
                                CanvasHeight: 400, //Alto del canvas
                                CropWidth: 600, //Ancho del recorte que se subirá
                                CropHeight: 400, //Alto del recorte que se subirá
                                MinWidth: 60, //Ancho mínimo del selector
                                MinHeight: 40, //Ancho mínimo del selector
                                KeepAspect: true,
                                Preview: false,
                                Daten: {
                                    Path: 'files/articulos_media/' + Articulo.id + '/' + moment().format('YYYYMMDDHHmmss') + '.jpg'
                                }
                            }
                        }
                    });
                    if (Img) ruta = Img.Msg;
                }

                if (kT == 'Tabla') {
                    contenido = [
                        ['Uno', 'Dos', 'Tres'],
                        [1, 2, 3],
                        [4, 5, 6],
                        [7, 8, 9]
                    ];
                };

                Ctrl.SeccionesCRUD.add({
                    articulo_id: Articulo.id,
                    indice: indice, // Luigi :: Agregar el campo para el registro.
                    tipo: kT,
                    ruta: ruta,
                    contenido: contenido
                });
            }

            Ctrl.eliminarSeccion = (S) => {
                Rs.confirmDelete({
                    Title: '¿Eliminar la Sección?',
                }).then(R => {
                    if (!R) return;
                    Ctrl.SeccionesCRUD.delete(S)
                        .then(() => { // Luigi :: Despues de borrar, se debe reorganizar el indice de cada seccion
                            angular.forEach(Ctrl.SeccionesCRUD.rows, (S, iS) => { // Luigi :: Recorremos las secciones
                                // Luigi :: Comparamos el indice, si es diferente, se actualiza
                                if (S.indice != iS + 1) {
                                    S.indice = iS + 1;
                                    S.changed = true; // Luigi :: Marcamos el registro para el guardado.
                                }
                            });
                            // Luigi :: Enviamos a guardar los datos modificados.
                            Ctrl.guardarArticulo();
                        });
                });
            };

            //Seccion Tabla
            Ctrl.agregarColumna = (S) => {
                var Tabla = S.contenido;
                angular.forEach(Tabla, (Fila) => {
                    Fila.push('');
                });
                S.changed = true;
            }

            Ctrl.eliminarColumna = (S, kC) => {
                var Tabla = angular.copy(S.contenido);
                angular.forEach(Tabla, (Fila) => {
                    Fila.splice(kC, 1);
                });
                S.contenido = Tabla;
                S.changed = true;
            }

            Ctrl.agregarFila = (S) => {
                var Tabla = S.contenido;
                var NuevaFila = angular.copy(Tabla[0]);
                NuevaFila = NuevaFila.map(V => { return null });

                Tabla.push(NuevaFila);
                S.changed = true;
            }

            Ctrl.eliminarFila = (S, kR) => {
                var Tabla = S.contenido;
                Tabla.splice(kR, 1);
                S.changed = true;
            }

            // Luigi :: Funcion para mover el indice, aumentar o decrementar.
            Ctrl.moverSeccion = (S, N) => {
                // Luigi :: declaramos variables para almacenar valores necesarios en el proceso.
                var nuevoIndice = S.indice + N;
                var elementoObjetivo;
                // Luigi :: Ciclo para validar el numero de indice
                for (let i = 0; i < Ctrl.SeccionesCRUD.rows.length; i++) {
                    if (Ctrl.SeccionesCRUD.rows[i].indice == nuevoIndice)
                        elementoObjetivo = Ctrl.SeccionesCRUD.rows[i];
                }
                // Luigi :: Si el elemenoObjetivo no existe, salimos.
                if (!elementoObjetivo)
                    return;

                // Luigi :: Almacenamos el valor del nuevo indice.
                S.indice = nuevoIndice;
                elementoObjetivo.indice = nuevoIndice - N;
                // Luigi :: Guardamos todos los registros modificados.
                S.changed = true;
                elementoObjetivo.changed = true;
            };     
        }
    ]);