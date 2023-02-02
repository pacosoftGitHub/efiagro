angular.module('ArticulosCtrl', [])
.controller('ArticulosCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 
	function($scope, $rootScope, $http, $injector, $mdDialog) {

		var Ctrl = $scope;
		var Rs = $rootScope;
		Ctrl.idLineaproductiva = undefined;
		Ctrl.filterAutor = "";
		Ctrl.filterKeys = [];
		Ctrl.filterTitulo = "";
	
		Ctrl.ArticulosCRUD = $injector.get('CRUD').config({ 
			base_url: '/api/articulos/articulos',
			limit: 1000,
			add_append: 'refresh',
			query_with: [ 'autor' ],
			order_by: [ '-created_at' ]
		});

		Ctrl.getArticulos = () => {
			Ctrl.ArticulosCRUD.get().then(() => {
				Ctrl.Articuloscopy = Ctrl.ArticulosCRUD.rows.slice();
			});
		};

		Ctrl.getArticulos();
			$http.post('api/lineasproductivas/obtener', {}).then(r => {
			Ctrl.lineas_productivas = r.data;
		    });
		
		Ctrl.nuevoArticulo = () => {

			Ctrl.ArticulosCRUD.dialog({
				usuario_id: Rs.Usuario.id,
				estado: 'Borrador'
			}, {
				title: 'Nuevo Articulo',
				only: ['titulo']
			}).then(r => {
				if(!r) return;
				Ctrl.ArticulosCRUD.add(r);
			});

		};


		Ctrl.editarArticulo = (A) => {
			$mdDialog.show({
				templateUrl: 'Frag/AdministracionGeneral.Articulos_ArticuloEditorDiag',
				controller: 'Articulos_ArticuloEditorCtrl',
				locals: { Articulo: A },
				scope: Ctrl.$new()
			});
		}


		//INICIO DEV ANGÉLICA ---> Filtro de búsqueda 
		Ctrl.suppressSpecialCharacters = (word) => { // suprimir algunos caracteres especiales -  funcion para buscar con tiltes
			return word.toLowerCase()
			.replace("é", "e")
			.replace("á", "a")
			.replace("í", "i")
			.replace("ó", "o")
			.replace("ú", "u");
		}

		Ctrl.filterArticulos = () => {
			//Filtro de linea productiva
			Ctrl.Articuloscopy = Ctrl.ArticulosCRUD.rows.slice(); //Cada que hagamos un filtro obtenemos los datos originales
			if (Ctrl.idLineaproductiva){
				Ctrl.Articuloscopy = Ctrl.Articuloscopy.filter(articulo => articulo.linea_productiva_id === Ctrl.idLineaproductiva);
			}
			//Filtro para autor
			if (Ctrl.filterAutor && Ctrl.filterAutor.length > 2){
				//toUpperCase() --> Para pasarlo a mayúscula
				Ctrl.Articuloscopy = Ctrl.Articuloscopy.filter(articulo => Ctrl.suppressSpecialCharacters(articulo.autor.nombre).indexOf(Ctrl.suppressSpecialCharacters(Ctrl.filterAutor))> -1); //indexOf para mirar si una cadena está contenida en otra y me dice en que posición está contenida
			}
			//Filtro de palabras clave, los chips
			if(Ctrl.filterKeys && Ctrl.filterKeys.length>0){
				// debugger;
				let index = 0; //Se necesita el índice del artículo que se está recorriendo
				let L = Ctrl.Articuloscopy.length;
				for (i = 0; i<L; i++){
					let found = false; //verificar si el articulo tiene la palabra clave, si la tiene no hace nada porque el articulo está en la lista, si no la tiene hay que eliminarlo
					if(Ctrl.Articuloscopy[index].palabras_clave){
						const keys = Ctrl.Articuloscopy[index].palabras_clave.split(",");
						keys.forEach(palabraClave => {
							Ctrl.filterKeys.forEach(key => {
								if (palabraClave.toUpperCase() === key.toUpperCase()){
									found = true;
								}
							})
						});
					}
					if (!found){
						Ctrl.Articuloscopy.splice(index, 1);
					}else{
						index ++;
						found = false;
					}
				};				
			}
			//Filtro para titulo (podria implementarse el autocompletar y el hamburguer icon)
			if (Ctrl.filterTitulo && Ctrl.filterTitulo.length > 2){
				//toUpperCase() --> Para pasarlo a mayúscula
				Ctrl.Articuloscopy = Ctrl.Articuloscopy.filter(articulo => Ctrl.suppressSpecialCharacters(articulo.titulo).indexOf(Ctrl.suppressSpecialCharacters(Ctrl.filterTitulo))> -1); //indexOf para mirar si una cadena está contenida en otra y me dice en que posición está contenida
			}
		} //FIN  DEV ANGÉLICA


	}
]);
