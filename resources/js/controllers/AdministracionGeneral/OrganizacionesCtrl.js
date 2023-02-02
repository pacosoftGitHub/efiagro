angular.module("OrganizacionesCtrl", []).controller("OrganizacionesCtrl", [
    "$scope",
    "$rootScope",
    "$http",
    "$state",
    "$injector",
    "$mdDialog",
    "Upload",  //DEV ANGÉLICA -->
    function($scope, $rootScope, $http, $state, $injector, $mdDialog, Upload) {

        var Ctrl = $scope;
        var Rs = $rootScope;
        var departamentos = [];

        Ctrl.Salir = $mdDialog.cancel;

        Ctrl.OrganizacionesCRUD = $injector.get("CRUD").config({
            base_url: "/api/organizaciones/organizaciones",
            limit: 1000,
            //add_append: "refresh",
            order_by: ["-created_at"],
            query_with:['linea_productiva']
        });
        Ctrl.perfil_id = Rs.Usuario.perfil_id;
        Ctrl.filterNombre = "";
        Ctrl.filterNit = "";

        Ctrl.filterNombre = "";
        Ctrl.filterNit = "";

        Ctrl.value = 0;

        Ctrl.myHTML =
        'I am an <code>HTML</code>string with ' +
        '<a href="#">links!</a> and other <em>stuff</em>';

        //INICIO DEV ANGÉLICA -- MURO
        Ctrl.OrganizacionesmuroseccionesCRUD = $injector.get('CRUD').config({
            base_url: '/api/organizacionesmurosecciones/organizacionesmurosecciones',
            limit: 1000,
			add_append: 'refresh',
            query_with: ['usuario'],
			order_by: [ '-created_at' ]
		});

        Ctrl.obtenerSecciones = (organizacion_id) => {
            Ctrl.OrganizacionesmuroseccionesCRUD.setScope('elorganizacion', organizacion_id).get();
		};

        //FIN DEV ANGÉLICA
        Ctrl.getOrganizacion = () => {
            // Ctrl.OrganizacionesCRUD.setScope('id', Rs.Usuario.organizacion_id); //con el setScope estoy haciendo un filtro en la BD para que él nos traiga sólo un registro
            Ctrl.OrganizacionesCRUD.get().then(() => {
                Ctrl.Organizacion = Ctrl.OrganizacionesCRUD.rows.find(O => O.id === Rs.Usuario.organizacion_id);

                if (!Ctrl.Organizacion){
                    Ctrl.Organizacion = Ctrl.OrganizacionesCRUD.rows[0];
                }
                Ctrl.obtenerSecciones(Ctrl.Organizacion.id);
                Ctrl.Organizacionescopy = Ctrl.OrganizacionesCRUD.rows.slice();
            });

        };

        Ctrl.getOrganizacion();

        //INICIO DEV ANGPELICA
        loadDepartamentos = (col_departamento) => {
            col_departamento.Options.options = departamentos;

            /*departamentos.forEach(departamento => {
                let codigo = departamento.codigo;
                let descripcion = departamento.descripcion;
                col_departamento.Options.options = {...col_departamento.Options.options,
                    [codigo]: descripcion // si quiero que en la base de datos se vea por codigos en departamento y municipio
                    //[descripcion]: descripcion // si quiero que en la base de datos se vea por nombres(descripcion) en departamento y municipio
                };
            });//Llena el select de departamentos
            */
        }

        loadMunicipios = (valorDepartamento, col_municipio) => {
            col_municipio.Options.options = {}; //limpia el select de municipios

            $http.post ('api/lista/obtener', { lista: 'Municipios', Op1: valorDepartamento }).then((r)=>{
                col_municipio.Options.options = r.data;
			});
            /*departamento.municipios.forEach(municipio => {
                let codigo = municipio.codigo;
                let descripcion = municipio.descripcion;
                col_municipio.Options.options = {...col_municipio.Options.options,
                    //[codigo]: descripcion ----> si quiero que en la base de datos se vea por codigos en departamento y municipio
                    [descripcion]: descripcion // si quiero que en la base de datos se vea por nombres(descripcion) en departamento y municipio
                };
            }); //se trae los municipios del departamento escogido
            */
        }

        inicializarListaDepartamentoMunicipio = () => {
            let col_departamento = Ctrl.OrganizacionesCRUD.columns.find(c => c.Field == 'departamento');
            loadDepartamentos(col_departamento);

            col_departamento.Options.onChangeFn = (valorDepartamento) => {
                let col_municipio = Ctrl.OrganizacionesCRUD.columns.find(c => c.Field == 'municipio');
                loadMunicipios(valorDepartamento, col_municipio);
            }
        }
        //FIN DEV ANGÉLICA

        //INICIO DEV ANGÉLICA
        Ctrl.nuevaOrganizacion = () => {  //Esta es una función que me crea automaticamente la modal y lleva la informacion a la BD desde la modal de CRUD
            inicializarListaDepartamentoMunicipio();
        //FIN DEV ANGÉLICA

            Ctrl.OrganizacionesCRUD.dialog({
                // Flex: 10,
                title: 'Crear Organización',
                Confirm: { Text: 'Crear Organizacion' }
            }).then(r  => {
                if (!r) return;

                Ctrl.OrganizacionesCRUD.add(r).then(u =>{
                    datos_organizacion = u;
                    console.log("organizacion", datos_organizacion);
                    $http.post ('/api/opcionesutil/adicionar',{organizacion_id : datos_organizacion.id}).then((r)=>{
                        if(!r) return;
                    });
                });
                
                Rs.showToast('Organización creada')
                
            });
        };

        Ctrl.getDepartamentos = () => {
			$http.post ('api/lista/obtener', { lista: 'Departamentos' }).then((r)=>{
                departamentos = r.data;
			});
		}

		Ctrl.getDepartamentos();

        Ctrl.editarOrganizacion = (O) => {
            inicializarListaDepartamentoMunicipio();
            let col_municipio = Ctrl.OrganizacionesCRUD.columns.find(c => c.Field == 'municipio');
            loadMunicipios(O.departamento, col_municipio);
			Ctrl.OrganizacionesCRUD.dialog(O, {
				title: 'Editar Organización' + O.nombre
			}).then(r => {
				if(r == 'DELETE') return Ctrl.OrganizacionesCRUD.delete(O);
                if (!r) return;
				Ctrl.OrganizacionesCRUD.update(r).then(() => {
                    Ctrl.getOrganizacion();
					Rs.showToast('Organización actualizada');
				});
			});
		}

        // Funcion para MARCAR/SELECCIONAR la organizacion que el usuario logeado va a trabajar
		Ctrl.seleccionar = (u, o) => {
            $http.post('/api/usuario/actualizarorganizacion', {
                usuario: u,
                organizacion: o
            }).then(() => {
                Rs.showToast("Se cambio la Organizacion.");
                $state.reload();
            });
        };

        // Funcion para DESMARCAR la organizacion que el usuario tiene por defecto
		Ctrl.quitar = (u) => {
            $http.post('/api/usuario/quitarorganizacion', {
                usuario: u
            }).then(() => {
                Rs.showToast("Se quito la Organizacion para el Usuario.");
                $state.reload();
            });
        };

		Ctrl.eliminarOrganizacion = (O) => {
			Rs.confirmDelete({
				Title: '¿Eliminar Organizacion #'+O.id+'?',
			}).then(d => {
				if(!d) return;
				Ctrl.OrganizacionesCRUD.delete(O);
			});
        }

        //Abre el modal de publicaciones del muro
		Ctrl.abrirOrganigrama = (O) => {
			$mdDialog.show({
				templateUrl: 'Frag/GestionOrganizacion.OrganigramaDiag',
				controller: 'OrganizacionDiagCtrl',
				locals: { Organizacion: O },
				fullscreen: false,
			});
        }


    //INICIO DEV ANGÉLICA
        //Abre el modal del un articulo de un muro de la organizacion
        Ctrl.abrirArticulomuro = (A) => {
			$mdDialog.show({
                templateUrl: 'templates/dialogs/image-editor.html',
				controller: 'ImageEditor_DialogCtrl',
				locals: {Organizacionesmurosecciones: A},
			});
        }

        //Carga imagen al servidor
        Ctrl.subirImagen = ($file) => {
            if(!$file) return;

            Upload.upload({
                url: 'api/main/upload-imagen',
                data: {file: $file,
                    Path: 'files/muro_media/' + Rs.Usuario.organizacion_id + '/' + moment().format('YYYYMMDDHHmmss') + '.jpg',
                    Ancho: 560, Alto: 300, Quality: 90
                }
            }).then(function (resp) {
                respuesta = 'Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data;
            }, function (resp) {
                respuesta = 'Error status: ' + resp.status;
            });
        }

        //Abre el modal del un articulo de un muro de la organizacion
        Ctrl.nuevoArticuloMuro = (O) => {
			$mdDialog.show({
				templateUrl: 'Frag/GestionOrganizacion.OrganizacionesmuroEditorDiag',
				controller: 'ArticulomuroEditDialogCtrl',
				locals: {  },
				fullscreen: false,
			}).then(function (resp) {
                Ctrl.OrganizacionesmuroseccionesCRUD.setScope('elorganizacion', Rs.Usuario.organizacion_id).get();
            }, function (resp) {
                respuesta = 'Error status: ' + resp.status;
            });

        }

        // Creamos listado de Tipo de novedad
        Ctrl.TipoNovedad = {
            'Parrafo': { Nombre: 'Parrafo', icono: 'fa-align-justify' },
            'Imagen': { Nombre: 'Imagen', icono: 'fa-image' }
        }

        Ctrl.DarFormatoFecha = (fecha) => {
            const dias = fecha.diff(now(), 'days');

            if (dias === 0) {
                return 'Publicado hoy';
            } else {
                if (dias > 30) {
                    return'Publicado hace ' + dias / 30 + ' meses';
                } else {
                    return'Publicado hace ' + dias + ' dias';
                }
            }
        }

        Ctrl.Update = () => {
            //alert("Update");
        }
    //FIN DEV ANGÉLICA

    //INICIO DEV ANGELICA --> O = Organizacion
    Ctrl.cargarImagen = async() => {
        var Imagen = await $mdDialog.show({
            templateUrl: 'templates/dialogs/image-editor.html',
            controller: 'ImageEditor_DialogCtrl',
            multiple: true,
            locals: {
                Config: {
                    Theme: 'default',
                    CanvasWidth: 200,
                    CanvasHeight: 200,
                    CropWidth: 200,
                    CropHeight: 200,
                    MinWidth: 50,
                    MinHeight: 50,
                    KeepAspect: true,
                    Preview: false,
                    Daten: {
                        Path: 'files/img_perfil_organizacion/' + Ctrl.Organizacion.id + '.jpg'
                    }
                }
            }
        });
        let logo = document.getElementById("logo_perfil");
        logo.src = "/../files/img_perfil_organizacion//" + Ctrl.Organizacion.id + ".jpg?d=" + new Date().getTime();
    };
    //FIN DEV ANGELICA


    //INICIO DEV ANGÉLICA
    Ctrl.filterOrganizacion = () => {
        //Filtro de tipo de organizacion
        Ctrl.Organizacionescopy = Ctrl.OrganizacionesCRUD.rows.slice(); //Cada que hagamos un filtro obtenemos los datos originales
        //Filtro para nombre
        if (Ctrl.filterNombre && Ctrl.filterNombre.length > 2){
            //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
            Ctrl.Organizacionescopy = Ctrl.Organizacionescopy.filter(O => O.nombre.toUpperCase().indexOf(Ctrl.filterNombre.toUpperCase())> -1); //indexOf para mirar si una cadena está contenida en otra y me dice en que posición está contenida
        }
        //Filtro para buscar Nit
        if (Ctrl.filterNit && Ctrl.filterNit.length > 2){
            //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
            Ctrl.Organizacionescopy = Ctrl.Organizacionescopy.filter(O => O.nit.toUpperCase().indexOf(Ctrl.filterNit.toUpperCase())> -1); //indexOf para mirar si una cadena está contenida en otra y me dice en que posición está contenida
        }
        if (Ctrl.filterLineaProductiva && Ctrl.filterLineaProductiva.length >= 1){
            //toUpperCase() --> Para pasarlo a mayúscula/ lo encuentra en minuscyulas o mayusculas
            Ctrl.Organizacionescopy = Ctrl.Organizacionescopy.filter(L => L.linea_productiva.nombre.toUpperCase().indexOf(Ctrl.filterLineaProductiva.toUpperCase())> -1);
        }
    } //FIN DEV ANGÉLICA
    }

]);
