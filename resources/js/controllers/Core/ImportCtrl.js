angular.module('ImportCtrl', [])
.controller('ImportCtrl', ['$scope', '$rootScope', '$http', '$mdDialog', '$sce', 'Upload', 'Config',
	function($scope, $rootScope, $http, $mdDialog, $sce, Upload, Config) {

		console.info('ImportCtrl');
		var Ctrl = $scope;
		var Rs = $rootScope;
		Ctrl.Cancel = function(){ $mdDialog.cancel(); }
		Ctrl.filterAccion = '';
		Ctrl.inArray = Rs.inArray;

		Ctrl.Config = {
			Titulo: 'Importar', TituloIcono: 'fa-upload', 
			Paso: 1,
			Pasos: [ '',
				'Subir Plantilla',
				'Verificar Datos',
				'Importando',
				'Finalizado'
			],
			PlantillaUrl: false,
			PlantillaMsg: 'Descarge la plantilla y diligenciela con sus datos luego puede cargarla en esta pantalla.',
			PlantillaMsg2: '',
			PlantillaDown: [ 'fa-download' ],
			UploadUrl: 'api/Archivos/upload',
			SyncUrl: '',
			UploadData: {},
			Campos: [],
			FilaInicial: 2,
			ImportAcciones: {
				Crear:      { cant: 0, icono: 'fa-plus', clase: 'bg-lightgreen' },
				Actualizar: { cant: 0, icono: 'fa-sync-alt', clase: 'bg-yellow' },
				Eliminar:   { cant: 0, icono: 'fa-trash', clase: 'bg-lightred' },
				Errores:    { cant: 0, icono: 'fa-exclamation-triangle', clase: 'bg-lightpurple' }
			},
			testUpload: false,
		};
		
		angular.extend(Ctrl.Config, Config);

		Ctrl.DownloadPlantilla = function(){
			$http.get(Ctrl.Config.PlantillaUrl, { responseType: 'arraybuffer' }).then(function(r) {
        		var blob = new Blob([r.data], { type: "application/vnd.ms-excel; charset=UTF-8" });
		        var filename = Ctrl.Config.PlantillaUrl.split('/').pop();
		        saveAs(blob, filename);
        	});
		};


		Ctrl.UploadTemplate = function(file, invalidfile){
			if(file) {
	            Upload.upload({
					url: Ctrl.Config.UploadUrl,
					method: 'POST',
					file: file,
					data: {
						Data:   Ctrl.Config.UploadData,
						Campos: Ctrl.Config.Campos,
						FilaInicial: Ctrl.Config.FilaInicial
					}
				}).then(function(r){

					Ctrl.ImportData = r.data;
					Ctrl.VerifyData();
					/*if(r.status == 200){
						
					}else{
						Ctrl.Config.Paso = 6;
					};*/
				});
			};
		};

		Ctrl.testUpload = () => {
			$http.post(Ctrl.Config.UploadUrl, {
				Data:   Ctrl.Config.UploadData,
				Campos: Ctrl.Config.Campos,
				FilaInicial: Ctrl.Config.FilaInicial
			}).then(r => {
				Ctrl.ImportData = r.data;
				Ctrl.VerifyData();
			});
		}


		CountAcciones = () => {
			angular.forEach(Ctrl.Config.ImportAcciones, (A) => {
				A.cant = 0;
			});

			angular.forEach(Ctrl.ImportData, (Row) => {
				Ctrl.Config.ImportAcciones[Row._import_action].cant ++;
			});

			//Ctrl.doSync(); //FIX
		};

		Ctrl.VerifyData = function(){
			

			if(Ctrl.ImportData.length > 0){
				Ctrl.Config.Paso = 2;
				CountAcciones();
			}else{
				Ctrl.finishSync('No se encontraron cambios', 'Alert');
			};

		}

		Ctrl.viewAcciones = (kA) => {
			if(Ctrl.filterAccion == kA) return Ctrl.filterAccion = '';
			Ctrl.filterAccion = kA;
		}

		//Ctrl.VerifyData();

		Ctrl.doSync = () => {
			Ctrl.Config.Paso = 3;
			$http.post(Ctrl.Config.SyncUrl, { ImportData: Ctrl.ImportData, Campos: Ctrl.Config.Campos }).then((r) => {
				Ctrl.finishSync('Sincronización terminada exitosamente', 'Ok');
			});
		}

		Ctrl.finishSync = (Msg, Status) => {
			Ctrl.Config.Paso = 4;
			Ctrl.FinishMsg = Msg;
			Ctrl.FinishStatus = Status;
		}

		Ctrl.finishDiag = () => {
			$mdDialog.hide();
		}

		Ctrl.DownloadErrors = function(){
			var Headers = [ 'Fila', 'Error' ];
			var e = {
        		filename: 'Errores_Importacion',
        		ext: 'xls',
        		sheets: [
        			{
						name: 'Errores',
						headers: Headers,
						rows: Ctrl.Errores,
					}
        		]
			};
			Rs.DownloadExcel(e);
		};

		if(Ctrl.Config.testUpload) Ctrl.testUpload(); //FIX

	}
]);