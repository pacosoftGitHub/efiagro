//INICIO DEV ANGÉLICA
angular.module('ListaEditDialogCtrl', [])
.controller('ListaEditDialogCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Lista',
	function($scope, $rootScope, $http, $injector, $mdDialog, Lista) {

		var Ctrl = $scope;
		var Rs = $rootScope;


		// debugger;
		Ctrl.Cancel = $mdDialog.cancel;
		Ctrl.Lista = angular.copy(Lista);
		Ctrl.url = '';
		Ctrl.Hide = $mdDialog.hide;
		//Ctrl.Autoincremental = false;

		/*Ctrl.ListaCRUD = $injector.get('CRUD').config({ 
			base_url: '/api/lista/lista',
			limit: 1000,
			add_append: 'refresh',
		});*/

		Ctrl.addListadetalle = () => {
			if(!Ctrl.Lista.listadetalle || Ctrl.Lista.listadetalle.length===0 || Ctrl.Lista.listadetalle [Ctrl.Lista.listadetalle.length-1].descripcion.length>0){
				let codigo = 0;
				if(Ctrl.Lista.autoincremental){
					if(!Ctrl.Lista.listadetalle || Ctrl.Lista.listadetalle.length===0){
						codigo = 1;

					}else{
						codigo = parseInt(Ctrl.Lista.listadetalle[Ctrl.Lista.listadetalle?.length-1].codigo) + 1;
					}
				}
				Ctrl.Lista.listadetalle.push({ //Cuando queramos que no se repitan datos guardados en base de datos
					id: -1,
					lista_id: Ctrl.Lista.id,
					codigo: Ctrl.Autoincremental ? codigo : '',
					descripcion: '',
					op1: '',
					op2: '',
					op3: '',
					op4: '',
					op5: '',
				})
				
			}
		}

		Ctrl.getLista = () => {
			$http.get ('api/lista/lista/'+ Ctrl.Lista.id, {}).then((r)=>{
				Ctrl.Lista = r.data;
				Ctrl.Autoincremental = Ctrl.Lista.autoincremental ===1 ; 
				Ctrl.addListadetalle();
			});
		}

		Ctrl.getLista();

		Ctrl.guardarLista = () => {
			$http.post('api/lista/actualizar', {Lista: Ctrl.Lista}).then((r)=>{
				Ctrl.Lista = r.data;
			})
		}

		
		Ctrl.eliminarLista = (C) => {
			if(C.id==-1){
				const index = Ctrl.Lista.listadetalle.findIndex(item => item.codigo === C.codigo);
				Ctrl.Lista.listadetalle.splice(index, 1);
			}else{
				Rs.confirmDelete({
					Title: '¿Eliminar elemento de la lista?',
				}).then(R => {
					$http.post('api/lista/delete', {id:C.id}).then((r)=>{
						const index = Ctrl.Lista.listadetalle.findIndex(item => item.codigo === C.codigo);
						Ctrl.Lista.listadetalle.splice(index, 1);
					})
	
					/*if(!R) return;
					Ctrl.ListaCRUD.delete(L);*/
				});

			}
			//revisar boton borrar, cancelar e igual borra
		}


	}

 
]);

//FIN DEV ANGÉLICA