//INICIO DEV ANGELICA
angular.module('ConfiguracionCtrl', [])
.controller('ConfiguracionCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 
	function($scope, $rootScope, $http, $injector, $mdDialog) {
		var Ctrl = $scope;
		var Rs = $rootScope;
		
		//var autoincrementals = ['Si', 'No'];

		Ctrl.ListaCRUD = $injector.get('CRUD').config({ 
			base_url: '/api/lista/listas',
			limit: 1000,
			add_append: 'refresh',
			order_by: [ '-lista' ]
		});


		Ctrl.getListas = () => {
			Promise.all([
				Ctrl.ListaCRUD.get()
			]).then(() => {
			});
			
		};

		Ctrl.getListas();

		/*Ctrl.nuevoUsuario = () => {
			Ctrl.UsuariosCRUD.dialog({}, {
				title: 'Agregar Usuario',
			}).then(r => {
				Ctrl.UsuariosCRUD.add(r).then(() => {
					Rs.showToast('Usuario creado');
				});
			});
		}*/

		Ctrl.nuevaLista = () => {

			Ctrl.ListaCRUD.dialog({}, {
			//Rs.BasicDialog({
				Flex: 30,
				Title: 'Crear Nueva Lista',
				/*Fields: [
					{ Nombre: 'lista',  Value: '', Type: 'textarea', Required: true},
					{ Nombre: 'autoincremental', Value: autoincrementals[0], Type: 'simplelist', List: autoincrementals, Required: true }
				],
				Confirm: { Text: 'Crear Lista' },*/
			}).then(r => {
				if(!r.autoincremental){
					r.autoincremental = false;
				}
				if (!r) return;
				Ctrl.ListaCRUD.add(r).then(() => {
					Rs.showToast('Lista creada');
				});
				/*if(!r) return;
				var NuevaLista = {
					lista: r.Fields[0].Value,
					autoincremental: r.Fields[1].Value === 'Si' ? 1:0
				};

				Ctrl.ListaCRUD.add(NuevaLista);*/
			});

		};

		//INICIO DEV ANGÉLICA 
		//Abre el modal para editar una lista
		Ctrl.editarLista = (O) => {
			$mdDialog.show({
				templateUrl: 'Frag/AdministracionGeneral.ListaEditorDiag',
				controller: 'ListaEditDialogCtrl',
				locals: {Lista: O},
				fullscreen: false,
			}).then(function (resp) {
				//Ctrl.OrganizacionesmuroseccionesCRUD.setScope('elorganizacion', Rs.Usuario.organizacion_id).get();
			}, function (resp) {
			});

		}

		
		Ctrl.eliminarLista = (C) => {
			Rs.confirmDelete({
				Title: '¿Eliminar la lista #'+C.id+'?',
			}).then(d => {
				if(!d) return;
				Ctrl.ListaCRUD.delete(C);
			});
		}
	}
]);
//FIN DEV ANGELICA