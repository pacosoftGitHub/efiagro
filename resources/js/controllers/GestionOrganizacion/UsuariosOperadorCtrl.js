angular.module('UsuariosOperadorCtrl', [])
.controller('UsuariosOperadorCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 
	function($scope, $rootScope, $http, $injector, $mdDialog) {
		
		//console.info('UsuariosCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;

		// Ctrl.UsuariosCRUD = $injector.get('CRUD').config({ 
		// 	base_url: '/api/usuario/usuarios-organizacion',
		// 	//limit: 100,
		// 	add_append: 'refresh',
		// 	//query_with: ['perfil', 'organizaciones_usuario']
		// });

		Ctrl.UsuariosCRUD = $injector.get('CRUD').config({ 
			base_url: '/api/usuario/usuarios',
			//limit: 100,
			add_append: 'refresh',
			query_scopes: [["organizacionusuario",Rs.Usuario.organizacion_id]]
			//query_with: ['organizaciones_usuario']
		});

		console.log("usuarios", Ctrl.UsuariosCRUD);
		
        // Esta funcion es previa, salen todos los usuarios
		// Ctrl.getUsuarios = () => {
		// 	Ctrl.UsuariosCRUD.get().then(() => {
		// 		//Ctrl.nuevoUsuario(); //FIX
		// 	});
		// };

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
				//Ctrl.UsuariosCRUD.setScope("organizacionUsuario", Rs.Usuario.organizacion_id); //Me trae las fincas del usuario
                Ctrl.UsuariosCRUD.get().then(() => {
					//Ctrl.Usuarioscopy = Ctrl.UsuariosCRUD.rows.slice();
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

		//INICIO JUAN TRAER NOMBRES DE DEPARTAMENTOS Y MUNICIPIO
        //Obtener el elemento de la lista
        Ctrl.getTablaDepartamentos = () => {
            $http.post ('api/lista/obtener', { lista: 'Departamentos' }).then((r)=>{
                Ctrl.DepartamentosTabla = r.data;
                Ctrl.Departamentos = [];
                for(let key in r.data){
                    Ctrl.Departamentos.push ({codigo: key, nombre: r.data[key]});
                }
            });
        }

        Ctrl.getTablaDepartamentos();


        //Obtener el elemento de la lista municiios
            Ctrl.getTablaMunicipios = () => {
            $http.post ('api/lista/obtener', { lista: 'Municipios' }).then((r)=>{
                Ctrl.MunicipiosTabla = r.data;
            });
        }
        
        Ctrl.getTablaMunicipios();
        //FIN JUAN TRAER NOMBRES DE DEPARTAMENTOS Y MUNICIPIOS

		Ctrl.nuevoUsuario = () => {
			Ctrl.UsuariosCRUD.dialog({}, {
				title: 'Agregar Usuario',
			}).then(r => {
				Ctrl.UsuariosCRUD.add(r).then(() => {
					Rs.showToast('Usuario creado');
				});
			});
		}

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

		Ctrl.editarUsuario = (U) => {
			inicializarListaDepartamentoMunicipio();
			let col_municipio = Ctrl.UsuariosCRUD.columns.find(c => c.Field == 'municipio');
			loadMunicipios(U.departamento, col_municipio);
			console.log('aqui edito este usuario', U, Ctrl.UsuariosCRUD);	
			Ctrl.UsuariosCRUD.dialog(U, {
				title: 'Editar el usuario: ' + U.nombres,
				except: [
					'finca_id',
					'organizacion_id',
					'perfil_id'
				],
				with_delete: false
			}).then(r => {
				if(!r) {Rs.showToast('Acción Cancelada'); return};
				if(r == 'DELETE') return Ctrl.UsuariosCRUD.delete(U);
				Ctrl.UsuariosCRUD.update(r).then(() => {
					Rs.showToast('Usuario actualizado');
				});
			});
		}

		 // Moda para el cambio de clave del usuario
		 Ctrl.asignarClave = U => {
			Rs.BasicDialog({
				Flex: 30,
				Title: `Cambiar Clave ${ U.nombres }`,
				Fields: [{
					Nombre: "Nueva Clave",
					Value: '', //U.contrasena,
					Type: "password",
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

		Ctrl.activarToggle = U => {

			var datos = {
				usuario_id: U.id,
				estado: !U.asociado_activo
			};
			
			$http.post('/api/usuario/actualizar-estado-usuario', datos)
			.then(r => {
				if(r){
					Rs.showToast("Cambio de ESTADO Exitoso.");
					console.log("resultado",r);
				}else{
					Rs.showToast("Cambio de ESTADO falló.");
					console.log("resultado",r);
				}
			});
		}

		//Filtros para estados
		Ctrl.filtrarActivo = function(item){
			if(!Ctrl.estadoActivo){
				return true;
			}else{
				return item.asociado_activo == 1 ? true : false;
			}
		}
		Ctrl.filtrarInactivo = function(item){
			if(!Ctrl.estadoInactivo){
				return true;
			}else{
				return item.asociado_activo == 2 ? true : false;
			}
		}


	}
]);