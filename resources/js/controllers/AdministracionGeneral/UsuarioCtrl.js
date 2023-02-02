angular.module('UsuariosCtrl', [])
    .controller('UsuariosCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog',
        function($scope, $rootScope, $http, $injector, $mdDialog) {

            var Ctrl = $scope;
            var Rs = $rootScope;
            Ctrl.filterDocumento = "";
            Ctrl.filterNombre = "";
            Ctrl.filterApellido = "";

            // Cargar CRUD angular para Usuarios
            Ctrl.UsuariosCRUD = $injector.get('CRUD').config({
                base_url: '/api/usuario/usuarios',
                //limit: 100,
                add_append: 'refresh',
                query_with: ['perfil', 'organizaciones_usuario'],
            });

            // console.log(Rs.Usuario);
            // console.log(Rs.Usuario.organizacion_id);
            Ctrl.getUsuarios = () => {
                if ( Rs.Usuario.organizacion_id > 0 ) {
                    
                    // Cargar los usuario que pertenecen a la organizacion seleccionada
                    /*
                    $http.post('api/organizaciones/usuarios', {
                        organizacion: Rs.Usuario.organizacion_id
                    }).then(res => {
                        if (res.data.length > 0) {
                            Ctrl.UsuariosCRUD.rows = res.data;
                        }
                        Ctrl.Usuarioscopy = Ctrl.UsuariosCRUD.rows;
                    });
                    */
                    Ctrl.UsuariosCRUD.setScope("laorganizacion", Rs.Usuario.organizacion_id); //Me trae las fincas del usuario
                    Ctrl.UsuariosCRUD.get().then(() => {
                        Ctrl.Usuarioscopy = Ctrl.UsuariosCRUD.rows.slice();
                    });

                } else {
                    // Ctrl.getUsuarios = () => {
                    // Asignar organizacion por defecto y obtener la informacion del usuario
                    // 20210505 Se quita funcion de filtrar por Organizacion.
                    // Ctrl.Usuarioscopy = Ctrl.UsuariosCRUD.setScope(
                    //     'laorganizacion',
                    //     Rs.Usuario.organizacion_id
                    // );
                    Ctrl.UsuariosCRUD.get().then(() => {
                        Ctrl.Usuarioscopy = Ctrl.UsuariosCRUD.rows.slice();
                        //Ctrl.cargarFincas(Ctrl.UsuariosCRUD.rows[1]); //FIX
                    });
                }
            };
            Ctrl.getUsuarios();

        //INICIO JUAN CARLOS
        loadDepartamentos = (col_departamento) => {
            col_departamento.Options.options = departamentos;
        }

        loadMunicipios = (valorDepartamento, col_municipio) => {
            col_municipio.Options.options = {}; //limpia el select de municipios

            $http.post ('api/lista/obtener', { lista: 'Municipios', Op1: valorDepartamento }).then((r)=>{
                col_municipio.Options.options = r.data;
			});
        }

        inicializarListaDepartamentoMunicipio = () => {
            let col_departamento = Ctrl.UsuariosCRUD.columns.find(c => c.Field == 'departamento');
            loadDepartamentos(col_departamento);

            col_departamento.Options.onChangeFn = (valorDepartamento) => {
                let col_municipio = Ctrl.UsuariosCRUD.columns.find(c => c.Field == 'municipio');
                loadMunicipios(valorDepartamento, col_municipio);
            }
        }

        Ctrl.getDepartamentos = () => {
			$http.post ('api/lista/obtener', { lista: 'Departamentos' }).then((r)=>{
                departamentos = r.data;
			});
		}

		Ctrl.getDepartamentos();
        //FIN JUAN CARLOS

            // Modal para la creacion del usuario.
            Ctrl.nuevo = () => {
                inicializarListaDepartamentoMunicipio();
                Ctrl.UsuariosCRUD.dialog({
                    tipo_documento: 'CC',
                    organizacion_id: Rs.Usuario.organizacion_id
                }, {
                    title: 'Agregar Usuario',
                    except: [
                        'finca_id',
                        // 'organizacion_id',
                    ],
                }).then(U => {
                    if (!U) return;
                    Ctrl.UsuariosCRUD.add(U)
                        .then(() => {
                            Rs.showToast('Usuario creado');
                        });
                });
            };

            // Modal para la edicion de los datos del usuarios
            Ctrl.editarUsuario = (U) => {
                inicializarListaDepartamentoMunicipio();
                let col_municipio = Ctrl.UsuariosCRUD.columns.find(c => c.Field == 'municipio');
                loadMunicipios(U.departamento, col_municipio);
                Ctrl.UsuariosCRUD.dialog(U, {
                    title: `Editar usuario: ${ U.nombres } ${ U.apellidos }`,
                    except: [
                        'finca_id'
                        // 'organizacion_id',
                    ]
                }).then(r => {
                    if (!r) return;
                    if (r == 'DELETE') return Ctrl.UsuariosCRUD.delete(U);
                    Ctrl.UsuariosCRUD.update(r).then(() => {
                        //Ctrl.UsuariosCRUD.get();
                        Rs.showToast(`Usuario ${ U.nombres } actualizado`);
                    });
                });
            };

            // Moda para el cambio de clave del usuario
            Ctrl.cambiarClave = U => {
                Rs.BasicDialog({
                    Flex: 30,
                    Title: `Cambiar Clave ${ U.nombres }`,
                    Fields: [{
                        Nombre: "Nueva Clave",
                        Value: '', //U.contrasena,
                        Type: "string",
                        Required: true,
                    }, ],
                    Confirm: { Text: "Actualiza Clave" }
                }).then(u => {
                    if (!u) return;

                    var nuevaclave = u.Fields[0].Value;
                    if (nuevaclave.trim() != '') {
                        var ClaveCambiada = {
                            usuario_id: U.id,
                            contrasena: u.Fields[0].Value,
                        };
                        // Accedemos mediante la API para el cambio de clave.
                        $http.post('/api/usuario/actualizar-clave', ClaveCambiada)
                            .then(() => {
                                Rs.showToast("Se cambio la clave.");
                            });
                    } else {
                        Rs.showToast("Se envio la clave en blanco. No se modifica.");
                    }
                });
            };

            // Modal para la carga de las fincas y las zonas del usuario seleccionado.
            Ctrl.cargarFincas = (U) => {
                $mdDialog.show({
                    templateUrl: 'Frag/AdministracionGeneral.UsuarioFincas',
                    controller: 'UsuarioFincaCtrl',
                    locals: {
                        DatosUsuario: U
                    },
                    fullscreen: false,
                });
            };

            // Modal para la carga de las organizaciones del usuario seleccionado.
            Ctrl.organizaciones = (U) => {
                $mdDialog.show({
                    templateUrl: 'Frag/AdministracionGeneral.UsuarioOrganizacion',
                    controller: 'UsuarioOrganizacionCtrl',
                    locals: {
                        DatosUsuario: U
                    },
                    fullscreen: false,
                });
            };

            //INICIO DEV ANGÉLICA
            Ctrl.filterUsuarios = () => {
                    // Filtro de tipo de Documento
                    Ctrl.Usuarioscopy = Ctrl.UsuariosCRUD.rows.slice(); //Cada que hagamos un filtro obtenemos los datos originales
                    if (Ctrl.filterDocumento && Ctrl.filterDocumento.length >= 1) {
                        //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
                        Ctrl.Usuarioscopy = Ctrl.Usuarioscopy.filter(U => U.documento == Ctrl.filterDocumento);
                    }

                    //Filtro para nombre
                    if (Ctrl.filterNombre && Ctrl.filterNombre.length > 2) {
                        //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
                        Ctrl.Usuarioscopy = Ctrl.Usuarioscopy.filter(U => U.nombres.toUpperCase().indexOf(Ctrl.filterNombre.toUpperCase()) > -1); //indexOf para mirar si una cadena está contenida en otra y me dice en que posición está contenida
                    }
                    //Filtro para buscar Nit
                    if (Ctrl.filterApellido && Ctrl.filterApellido.length > 2) {
                        //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
                        Ctrl.Usuarioscopy = Ctrl.Usuarioscopy.filter(U => U.apellidos.toUpperCase().indexOf(Ctrl.filterApellido.toUpperCase()) > -1); //indexOf para mirar si una cadena está contenida en otra y me dice en que posición está contenida
                    }
                }
                //FIN DEV ANGÉLICA


            //Opciones para importar la plantilla
            Ctrl.subirArchivo = (archivo) =>{
                if(archivo.length > 0){
                    Ctrl.plantilla = archivo;
                    //console.log(archivo);
                }else{
                    $mdDialog.show(
                        $mdDialog.alert()
                          .clickOutsideToClose(true)
                          .title('SITUACIÓN CON EL ARCHIVO')
                          .textContent('No se ha seleccionado ninguna plantilla de usuarios')
                          .ariaLabel('NO HAY ARCHIVO')
                          .ok('Entendido!')
                          //.targetEvent(ev)
                      );
                }

            }
            Ctrl.pruebaPost = ($files) => {
                var datos = new FormData();
                datos.append("organizacion_id", Rs.Usuario.organizacion_id);
                datos.append("archivo", Ctrl.plantilla[0]);

                var config = {
                    method : 'POST',
                    headers: {'Content-Type': undefined}
                }
                $http.post('/api/usuario/importar-test',datos,config).then((respuesta) => {
                    //alert("se logro");
                    console.log(respuesta.data);
                    $mdDialog.show({
                        templateUrl: 'Frag/AdministracionGeneral.UsuariosImportarDiag',
                        controller: 'UsuariosImportarCtrl',
                        parent: angular.element(document.body),
                        locals: {
                            usuarios: respuesta
                        },
                        fullscreen: false,
                        clickOutsideToClose: true,
                    });
                    
                });
            }
        }

    ]);
