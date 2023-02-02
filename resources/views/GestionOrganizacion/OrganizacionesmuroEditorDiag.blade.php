<md-dialog class="vh75 w80p mxw550" layout=column >
	
	<div layout class="" layout-align="center center">
		<div class="text-clear padding-left md-title" flex>Edición de Publicación</div>
		<md-button ng-click="Cancel()" class="md-icon-button no-margin">
			<md-icon md-font-icon="fa-times"></md-icon>
		</md-button>
	</div>

	<div layout=column class="overflow-y">
		<div layout=column class="padding-0-10">
			<text-angular ta-toolbar="[[],['bold','ul','ol']]" ng-model="contenido"></text-angular>
		</div>

		<div layout style="margin-top: 20px" layout class="padding-0-10">

			<md-input-container class="no-margin md-title" md-no-float flex>
				<input type="text" ng-model="url" placeholder="Url">
			</md-input-container>
		</div>

		<div layout style="margin-top: 20px" class="padding-0-100">
			<input class="ng-hide" id="file-id" name="archivossubidos[]" multiple type="file" accept="image/png, .jpeg, .jpg, image/gif" />
			<label for="file-id" style="padding: 0px 220px" class="md-button md-raised md-primary" ngf-select="subirImagen($file)" ngf-accept="'image/*'">Elegir Imagen <i class="far fa-image fa-lg"></i></label>
			<!--//Otro botón que funciona para llevar imagen al servidor
			<md-button class="md-icon-button" ngf-select="subirImagen($file)" ngf-accept="'image/*'">
            	<md-tooltip md-direction>Agregar Imagen</md-tooltip>
            	<md-icon md-font-icon="fa-image fa-lg fa-fw"></md-icon>
            </md-button>-->
		</div>


	</div>

	<div layout class="border-top">
		<span flex></span>
		<md-button class="md-raised md-primary" ng-click="crearSeccion()">
			<md-icon md-font-icon="fa-save"></md-icon>Publicar
		</md-button>
	</div>

</md-dialog>