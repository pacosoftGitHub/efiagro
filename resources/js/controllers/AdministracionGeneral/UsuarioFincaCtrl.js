angular.module('UsuarioFincaCtrl', ['ngFileUpload']) //ngFileUpload
    .controller('UsuarioFincaCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'DatosUsuario',
        function($scope, $rootScope, $http, $injector, $mdDialog, DatosUsuario) {

            var Ctrl = $scope;
            var Rs = $rootScope;
            Ctrl.Cancel = $mdDialog.cancel;
            Ctrl.UsuarioFinca = DatosUsuario;

            // Datos por defecto para personalizacion de labores
            var zonaSeleccionada = 0;
            var lineaSeleccionada = 0;
            var loteSeleccionado = 0;

            //INICIO DEV ANGÉLICA
            //Para leer un archivo de excel
            Ctrl.SelectFile = function(file) {
                Ctrl.SelectedFile = file;
            };
            Ctrl.Upload = (L) => {
                //debugger;
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
                if (regex.test(Ctrl.SelectedFile.name.toLowerCase())) {
                    if (typeof(FileReader) != "undefined") {
                        var reader = new FileReader();
                        //For Browsers other than IE.
                        if (reader.readAsBinaryString) {
                            reader.onload = function(e) {
                                Ctrl.ProcessExcel(e.target.result, L);
                            };
                            reader.readAsBinaryString(Ctrl.SelectedFile);
                        } else {
                            //For IE Browser.
                            reader.onload = function(e) {
                                var data = "";
                                var bytes = new Uint8Array(e.target.result);
                                for (var i = 0; i < bytes.byteLength; i++) {
                                    data += String.fromCharCode(bytes[i]);
                                }
                                Ctrl.ProcessExcel(data, L);
                            };
                            reader.readAsArrayBuffer(Ctrl.SelectedFile);
                        }
                    } else {
                        alert("Este navegador no soporta HTML5");
                    }
                } else {
                    alert("Por favor subir un archivo de excel vàlido.");
                }
            };

            Ctrl.ProcessExcel = function(data, L) {
                debugger;
                //Read the Excel File data.
                var workbook = XLSX.read(data, {
                    type: 'binary'
                });

                //Fetch the name of First Sheet.
                var firstSheet = workbook.SheetNames[0];

                //Read all rows from First Sheet into an JSON array.
                var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
                L.coordenadas = '';
                excelRows.forEach(element => {
                    //console.log(element.lat);
                    if (L.coordenadas.length > 0 ){
                        L.coordenadas += ',';
                    }
                    L.coordenadas += '{"lat":' + element.lat + ', "lng":' + element.lng + '}';
                    
                });
                L.coordenadas = '[' + L.coordenadas + ']';
            };
            //FIN DEV ANGELICA

            // Cargar las fincas del usuario seleccionado
            $http.post('api/fincas/usuario', {
                usuario: Ctrl.UsuarioFinca.id
            }).then(res => {
                if (res.data.length > 0) {
                    Ctrl.Fincas = res.data;
                    // console.log(Ctrl.Fincas);
                    Ctrl.cargarLotes(Ctrl.Fincas[0]);
                }
            });

            // Cargar los lotes de la finca seleccionada
            var fincaDefault = 0;
            Ctrl.cargarLotes = (F) => {
                Ctrl.F = F;
                loteSeleccionado = 0;
                lineaSeleccionada = 0;
                $http.post('api/lotes/finca', {
                    finca: F.id
                }).then(res => {
                    Ctrl.Lotes = res.data;
                    //console.log('Informacion de lote: ', Ctrl.Lotes[0]);
                    calcularZona(F);
                    // Ctrl.LoteSeleccionado = Ctrl.Lotes[0];

                    if (Ctrl.Lotes[0]) {
                        // console.log(Ctrl.Lotes[0]);
                        Ctrl.cargarLote(Ctrl.Lotes[0]);
                        loteSeleccionado = Ctrl.Lotes[0].id;
                        lineaSeleccionada = Ctrl.Lotes[0].linea_productiva_id;
                    } else {
                        Ctrl.L = 0;
                        console.log('No hay lotes en la finca');
                    }
                    // if ( Ctrl.LoteSeleccionado ) {
                    //     console.log('Lote: ' + Ctrl.LoteSeleccionado.id);
                    // } else {
                    //     console.log('No existe lote.');
                    // }
                });
                fincaDefault = F;
            };

            Ctrl.formularioNuevaFinca = () => {
                Ctrl.F = null;
                fincaDefault = null;
            };

            // Funcion para la carga de informacion de cada lote por Finca
            Ctrl.cargarLote = (L) => {
                // console.log(L);
                Ctrl.L = L;
                loteSeleccionado = L.id;
                lineaSeleccionada = L.linea_productiva_id;
                //Ctrl.personalizarLabores(); //FIX
                //console.log('Informacion de otro lote: ', L);
            };

            Ctrl.formularioNuevoLote = () => {
                Ctrl.L = null;
            };

            // Obtener el listado de las lineas productivas
            $http.post('api/lineasproductivas/obtener', {})
                .then(res => {
                    Ctrl.Lineasproductivas = res.data;
                    // console.log(Ctrl.Lineasproductivas);
                });

            // Obtener el listado de las labores.
            $http.post('api/labores/obtener', {})
                .then(res => {
                    Ctrl.Labores = res.data;
                });

            // Obtener los datos de la lista 3: Municipios
            $http.post('api/lista/listacompleta', {
                id: 3
            }).then((r) => {
                Ctrl.Municipios = r.data;
            });

            // Obtener los datos de la lista 2: Departamentos
            $http.post('api/lista/listacompleta', {
                id: 2
            }).then((r) => {
                Ctrl.Departamentos = r.data;
            });

            // Obtener los datos de la lista 6: Tipo de Cultivo
            $http.post('api/lista/listacompleta', {
                id: 5
            }).then((r) => {
                Ctrl.TipoCultivo = r.data;
            });

            // Obtener los datos de la lista 7: Tipos de Suelo
            $http.post('api/lista/listacompleta', {
                id: 4
            }).then((r) => {
                Ctrl.TipoSuelo = r.data;
            });

            // Guardar / Actualizar los datos de la finca
            Ctrl.guardarFinca = (F) => {
                $http.post('api/fincas/actualizar', {
                    Datos: F
                });
                Ctrl.Cancel();
            };

            // Agregar registro de finca.
            Ctrl.nuevaFinca = (Fn) => {
                $http.post('api/fincas/crear', {
                    Datos: Fn,
                    usuario: Ctrl.UsuarioFinca.id
                });
                Ctrl.Cancel();
            };

            // Guardar / Actualizar lote de la finca.
            Ctrl.guardarLote = (L) => {
                $http.post('api/lotes/actualizar', {
                    Datos: L
                });
                Ctrl.Cancel();
            };

            // Agregar registro de lote
            Ctrl.nuevoLote = (L) => {
                $http.post('api/lotes/crear', {
                    Datos: L,
                    finca: fincaDefault.id,
                    organizacion: 1 //Actualizar organizaciòn
                });
                Ctrl.Cancel();
            };

            // Obtener los datos maximos y minimos por cada zona y linea productiva
            $http.post('api/zonas/obtener', {}).then((r) => {
                Ctrl.zonas = r.data;
            });

            Ctrl.recalcularZona = (data) => {
                if (data['temperatura'] > 0 && data['humedad_relativa'] > 0 && data['precipitacion'] > 0 && data['altimetria'] > 0 && data['pendiente'] > 0 && data['brillo_solar'] > 0) {
                    calcularZona = (data);
                }
            };

            calcularZona = (Finca) => {
                // console.log('Finca: ', Finca);
                // recorrer las zonas y validar los valores contra la finca, para obtener porcentajes
                zonaprimaria = [];
                angular.forEach(Ctrl.zonas, function(data) {
                    var contadorzona = 0;

                    if (data['temperatura_min'] <= Finca['temperatura'] && data['temperatura_max'] >= Finca['temperatura']) {
                        contadorzona++;
                    }
                    if (data['humedad_relativa_min'] <= Finca['humedad_relativa'] && data['humedad_relativa_max'] >= Finca['humedad_relativa']) {
                        contadorzona++;
                    }
                    if (data['precipitacion_min'] <= Finca['precipitacion'] && data['precipitacion_max'] >= Finca['precipitacion']) {
                        contadorzona++;
                    }
                    if (data['altimetria_min'] <= Finca['altimetria'] && data['altimetria_max'] >= Finca['altimetria']) {
                        contadorzona++;
                    }
                    if (data['pendiente_min'] <= Finca['pendiente'] && data['pendiente_max'] >= Finca['pendiente']) {
                        contadorzona++;
                    }
                    if (data['brillo_solar_min'] <= Finca['brillo_solar'] && data['brillo_solar_max'] >= Finca['brillo_solar']) {
                        contadorzona++;
                    }
                    zonaprimaria.push({
                        'average': parseInt(contadorzona / 6 * 100),
                        'zona_id': data['id'],
                        'description': data['descripcion'],
                        'amount': contadorzona
                    });
                });
                zonaprimaria.reverse((a, b) => a.average > b.average);
                // console.log(zonaprimaria);
                var texto = zonaprimaria[0].description + ': Coincidencia del ' + zonaprimaria[0].average + '%';
                Ctrl.zp = (zonaprimaria[0].average < 70) ? 'Subzona de ' + texto : 'Zona de ' + texto;
                zonaSeleccionada = zonaprimaria[0].zona_id;
                // console.log('Zona primaria: ', zonaprimaria);
            };

            Ctrl.personalizarLabores = () => {
                // console.log(`zona ${zonaSeleccionada}, Linea ${lineaSeleccionada}, Lote ${loteSeleccionado}`);
                if (zonaSeleccionada > 0 && lineaSeleccionada > 0 && loteSeleccionado > 0) {
                    $http.post('api/loteslabores/personalizar', {
                        Datos: {
                            'lote': loteSeleccionado,
                            'linea': lineaSeleccionada,
                            'zona': zonaSeleccionada
                        }
                    });
                    //Ctrl.Cancel();
                    $mdDialog.show({
                        templateUrl: 'Frag/AdministracionGeneral.UsuarioLabores',
                        controller: 'UsuarioLaboresCtrl',
                        locals: {
                            DatosLote: loteSeleccionado
                        },
                        multiple: true,
                        fullscreen: false,
                    });
                } else {
                    console.log('Aun no se crea Lote para la finca.');
                }
                // console.log('Lote: ' + Lote.id, Labor);
                // $http.post('api/loteslabores/crear', {
                //     Datos: {
                //         'lote': 20, // Lote['id'],
                //         'labor': 23, // Labor['id'],
                //         'labor_des': 'CORTADO CNSTANTE', // Labor['labor'],
                //         'inicio': 15, // Lote['inicio'],
                //         'frecuencia': 35, // Lote['frecuencia'],
                //         'margen': 3  // Lote['margen']
                //     }
                // });
                // Ctrl.Cancel();
            };


            Ctrl.OrganizacionLinea = (Linea) => {
                $http.post('api/organizaciones/linea', {
                    linea: Linea
                }).then((r) => {
                    Ctrl.OrganizacionLinea = r.data;
                    console.log(Ctrl.OrganizacionLinea);
                });
                console.log(Linea);
            };
            // Modal para cargar el cronograma de labores.
            // Ctrl.cargarCronograma = ( L ) => {
            //     Ctrl.Cancel();
            //     $mdDialog.show({
            //         templateUrl: 'Frag/AdministracionGeneral.UsuarioLabores',
            //         controller: 'UsuarioLaboresCtrl',
            //         locals: { 
            //             DatosLote: 'Labor bien bonita'
            //         },
            //         fullscreen: false,
            //     });
            // };
        }
    ]);
