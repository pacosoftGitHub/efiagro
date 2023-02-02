//INICIO DEV ANGÉLICA
angular.module('ArticulomuroEditDialogCtrl', [])
.controller('ArticulomuroEditDialogCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Upload', 
	function($scope, $rootScope, $http, $injector, $mdDialog, Upload) {

		console.info('ArticulomuroEditDialogCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;

		// debugger;
		Ctrl.Cancel = $mdDialog.cancel;
		Ctrl.contenido = '';
		Ctrl.url = '';
		Ctrl.Hide = $mdDialog.hide;

		Ctrl.organizacionesmuroseccionesCRUD = $injector.get('CRUD').config({ 
			base_url: '/api/organizacionesmurosecciones/organizacionesmurosecciones',
			limit: 1000,
			add_append: 'refresh',
		});

/*
		if(Organizacionesmurosecciones !== undefined){
			Ctrl.Organizacionesmurosecciones = angular.copy(Organizacionesmurosecciones);
			console.log(Organizacionesmurosecciones);			
		}
*/

		Ctrl.guardarOrganizacionesmuro = () => {
			Ctrl.$parent.OrganizacionesmuroseccionesCRUD.update(Ctrl.Organizacionesmurosecciones).then(() => {
				var SeccionesCambiadas = Ctrl.SeccionesCRUD.rows.filter(s => s.changed);
				if(SeccionesCambiadas.length > 0){
					Ctrl.SeccionesCRUD.updateMultiple(SeccionesCambiadas).then(() => {
					});
				}
			});
		}

		//INICIO DEV ANGÉLICA --> Se crea sección para las publicaciones, se envía ruta = Path llamando a Upload

		Ctrl.crearSeccion = async () => {
			const ruta = 'files/muro_media/' + Rs.Usuario.organizacion_id + '/' + moment().format('YYYYMMDDHHmmss') + '.jpg';

			Ctrl.organizacionesmuroseccionesCRUD.add({
				organizacion_id: Rs.Usuario.organizacion_id,
				usuario_id: Rs.Usuario.id,
				contenido: Ctrl.contenido,
				ruta: Ctrl.file?ruta:'',
				url: Ctrl.url
			}).then(function (resp) {
				//console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
				if(Ctrl.file){ //si no hay archivo que no envíe la imagen
					debugger;
					Upload.upload({
						url: 'api/main/upload-imagen',
						data: {file: Ctrl.file,
							Path: ruta,
							Alto: 300, 
							Ancho: 560, 
							Quality: 90
						}
					}).then(function (resp) {
						//console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
						Ctrl.Hide();
	
					}, function (resp) {
						console.log('Error status: ' + resp.status);
						return;
					});
				}else{
					Ctrl.Hide();
				}
			}, function (resp) {
				console.log('Error status: ' + resp.status);
				return;
			});
			//Aqui falta controlar el then y la excepción
			
			
		}

		Ctrl.eliminarSeccion = (S) => {
			Rs.confirmDelete({
				Title: '¿Eliminar la Sección?',
			}).then(R => {
				if(!R) return;
				Ctrl.SeccionesCRUD.delete(S);
			});
		}
		//FIN DEV ANGÉLICA

		//INICIO DEV ANGÉLICA Carga imagen al servidor
		Ctrl.subirImagen = ($file) => {
			if(!$file) return;

			//Capturar imagen al dar clic en el boton publicar
			Ctrl.file = $file; //capturo la variable
/*
			Upload.upload({
				url: 'api/main/upload-imagen',
				data: {file: $file,
					Path: 'files/muro_media/' + Rs.Usuario.organizacion_id + '/' + moment().format('YYYYMMDDHHmmss') + '.jpg',
					Ancho: 800, Alto: null, Quality: 90
				}
			}).then(function (resp) {
				console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
			}, function (resp) {
				console.log('Error status: ' + resp.status);
			});*/
		}

		//FIN DEV ANGÉLICA

	}

 
]);

//FIN DEV ANGÉLICA