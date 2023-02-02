angular.module('UsuarioLaboresCtrl', [])
    .controller('UsuarioLaboresCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'DatosLote',
        function($scope, $rootScope, $http, $injector, $mdDialog, DatosLote) {

            var Ctrl = $scope;
            var Rs = $rootScope;
            Ctrl.Cancel = $mdDialog.cancel;
            
            let anioActual = new Date().getFullYear()
            Ctrl.anioSelected = angular.copy(anioActual);

            // cargar listado de años, desde el 2021
            Ctrl.anios = [
                (anioActual - 1),
                anioActual,
                (anioActual + 1)
            ];

            // Funcion para el numero de la semana de una fecha establecida.
            // TOMADO DE: https://es.stackoverflow.com/questions/110209/encontrar-semana-del-a%C3%B1o-con-javascript?newreg=e65a27537fe749d4ad4bad31604ae00f
            // Date.prototype.numeroSemana = function ( fecha ) {
            numeroSemana = function(fecha) {
                // console.log(fecha);
                var d = new Date(fecha); // Creamos un nuevo Date con la fecha
                d.setHours(0, 0, 0, 0); // Limpiamos la hora estableciendo valores cero
                d.setDate(d.getDate() + 4 - (d.getDay() || 7)); // Recorremos los días para asegurarnos de estar "dentro de la semana"
                return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7); //Finalmente, calculamos redondeando y ajustando por la naturaleza de los números en JS:
            };

            // Cargar la informacion de labores del lote.
            Ctrl.cargarLabores = () => {
                $http.post('api/loteslabores/loteid', {
                    lote: DatosLote
                }).then((r) => {
                    InfoLabores = r.data;
                    cronograma(Ctrl.anioSelected);
                });
            };

            // Funcion para cargar los datos que se llevaran al cronograma
            cronograma = (anio) => {
                // obtenemos el primer dia del año, para saber los dias para el primer lunes del año.
                var primerdiaanio = new Date(anio, 0, 1).getDay();
                var numeroSemanasAnio = (primerdiaanio == 1) ? 53 : 52;
                switch (primerdiaanio) {
                    case 0:
                        diasParaLunes = 1;
                        break;
                    case 1:
                        diasParaLunes = 0;
                        break;
                    default:
                        diasParaLunes = 9 - primerdiaanio;
                        break;
                }
                var primerLunes = new Date(anio, 0, diasParaLunes);
                var lunesEnero = primerLunes.getFullYear() + '-' + (primerLunes.getMonth() + 1) + '-' + primerLunes.getDate();
                var encabezado = [];
                // organizar el valor del primer dato del arreglo (pendiente)
                // encabezado.push({ semana: 1, fecha: lunesEnero });
                // Crear arreglo para el encabezado de los datos.
                var lunesSiguiente = primerLunes;
                for (var i = 1; i <= numeroSemanasAnio; i++) {
                    encabezado.push({ semana: i, fecha: lunesSiguiente, fecha_corta: moment(lunesSiguiente).format('DD MMM') });
                    lunesSiguiente = new Date(lunesSiguiente.setDate(lunesSiguiente.getDate() + 7));
                }
                Ctrl.encabezado = encabezado;

                var detalle = [];
                // validar el año de establecimiento contra el año de la consulta del cronograma de labores.
                var anioEstablecimiento = InfoLabores[0]['fecha_establecimiento'].substr(0, 4);
                var mesEstablecimiento = InfoLabores[0]['fecha_establecimiento'].substr(5, 2);
                var diaEstablecimiento = InfoLabores[0]['fecha_establecimiento'].substr(8, 2);

                // Establecer la semana de inicio
                var semanaInicio = numeroSemana(new Date(anioEstablecimiento, mesEstablecimiento - 1, diaEstablecimiento));

                var residuo;
                for (let d = 0; d < InfoLabores.length; d++) {
                    var frecuencia = InfoLabores[d]['frecuencia'];
                    var frecuenciaPrevia = frecuencia - 1;
                    var semanaEstablecimiento = semanaInicio;
                    var semanaInicial = semanaEstablecimiento + InfoLabores[d]['inicio'];
                    if (anioEstablecimiento == Ctrl.anioSelected) {
                        var linea = [];
                        for (let j = 1; j <= numeroSemanasAnio; j++) {
                            if (j == semanaEstablecimiento) {
                                linea.push({ semana: j, base: 'Arranca', inicio: '', tipo: 'establecimiento' });
                            } else {
                                if (j == semanaInicial) {
                                    linea.push({ semana: j, base: '', inicio: 'Inicio', tipo: 'principal' });
                                } else {
                                    if (j > semanaInicial + 1) {
                                        residuo = (j - semanaInicial) % frecuencia;
                                        if (residuo == 0) {
                                            linea.push({ semana: j, base: '', inicio: '', tipo: 'principal' });
                                        } else if (residuo == frecuenciaPrevia) {
                                            linea.push({ semana: j, base: '', inicio: '', tipo: 'secundaria' });
                                        } else if (residuo == 1) {
                                            linea.push({ semana: j, base: '', inicio: '', tipo: 'secundaria' });
                                        } else {
                                            linea.push({ semana: j, base: '', inicio: '', tipo: '' });
                                        }
                                    } else {
                                        linea.push({ semana: j, base: '', inicio: '', tipo: '' });
                                    }
                                }
                            }
                        }
                        detalle.push(linea);
                    } else if (anioEstablecimiento < Ctrl.anioSelected) {
                        // Establecer la diferencia de años para saber el inicio de periodicidad.
                        restaAnio = Ctrl.anioSelected - anioEstablecimiento;
                        var sem = semanaInicial;
                        for (var ra = 1; ra <= restaAnio; ra++) {
                            while (sem < numeroSemanasAnio) {
                                sem += frecuencia;
                            }
                            sem = sem - numeroSemanasAnio;
                        }
                        var linea = [];
                        for (let j = 1; j <= numeroSemanasAnio; j++) {
                            if (j > sem) {
                                residuo = (j - sem) % frecuencia;
                                if (residuo == 0) {
                                    linea.push({ semana: j, base: '', inicio: '', tipo: 'principal' });
                                } else if (residuo == frecuenciaPrevia) {
                                    linea.push({ semana: j, base: '', inicio: '', tipo: 'secundaria' });
                                } else if (residuo == 1) {
                                    linea.push({ semana: j, base: '', inicio: '', tipo: 'secundaria' });
                                } else {
                                    linea.push({ semana: j, base: '', inicio: '', tipo: '' });
                                }
                            } else {
                                linea.push({ semana: j, base: '', inicio: '', tipo: '' });
                            }
                        }
                        detalle.push(linea);
                    } else {
                        console.log(`El año de establecimiento es superior al año de consulta del cronograma.`);
                    }
                }

                Ctrl.detalle = detalle;
                Ctrl.InfoLabores = InfoLabores;
            };

            Ctrl.cambiarAnio = (a) => {
                Ctrl.anioSelected = a;
                cronograma(a);
            };

            // Funcion para guardar la labor personalizada.
            // Ctrl.guardarLabor = () => {
            //     $http.post('api/loteslabores/crear', {
            //         lote_id: 21,
            //         labor_id: 0,
            //         labor: Ctrl.labornombre,
            //         inicio: Ctrl.laborinicio,
            //         frecuencia: Ctrl.laborfrecuencia,
            //         margen: Ctrl.labormargen
            //     });
            //     cronograma(Ctrl.anioSelected);
            //     // Ctrl.Cancel();
            //     // $http.post('api/loteslabores/crear');
            // };

            Ctrl.agregarLabor = () => {
                let nuevaLabor = angular.copy(Ctrl.nuevaLabor);
                if (nuevaLabor.trim() == '') return;

                $http.post('api/loteslabores/crear', {
                    lote_id: DatosLote,
                    labor_id: null,
                    labor: nuevaLabor,
                    inicio: 1,
                    frecuencia: 1,
                    margen: 1
                }).then(() => {
                    Ctrl.nuevaLabor = '';
                    Ctrl.cargarLabores();
                });
            };

            Ctrl.actualizarLabor = (L) => {
                // actualizar la labor.
                $http.post('api/loteslabores/actualizar', {
                    lote_id: DatosLote,
                    labor: L.labor,
                    inicio: L.inicio,
                    frecuencia: L.frecuencia,
                    margen: L.margen
                });   
                cronograma(Ctrl.anioSelected);
            };

            Ctrl.cargarLabores();
        }
    ]);

// Referencias
// https://www.it-swarm-es.com/es/javascript/como-obtener-el-primer-dia-del-ano-actual-en-javascript/1071710421/
// https://www.codegrepper.com/code-examples/javascript/date.tostring%28+dd%2Fmm%2Fyyyy+%29+javascript
// https://unipython.com/sumar-y-restar-dias-a-una-fecha-en-java-script/