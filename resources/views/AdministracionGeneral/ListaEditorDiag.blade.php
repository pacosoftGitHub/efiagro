<md-dialog class="vh75 w80p mxw900" layout=column >
	
	<div flex layout class="" layout-align="center center">
		<div class="text-clear padding-left md-title" flex>Edición de Lista</div>
		<md-button ng-click="Cancel()" class="md-icon-button no-margin">
			<md-icon md-font-icon="fa-times"></md-icon>
		</md-button>
	</div>

	<div layout=column class="overflow-y">

		@{{Lista.lista}}

			<md-input-container class="md-block">
			<md-switch class="md-primary" name="autoincremental" ng-model="Autoincremental" required>
			Autoincremental.
			</md-switch>
			@{{autoincremental}}
			<div ng-messages="projectForm.special.$error" multiple>
			<div ng-message="required">
				Habilitas esta opción si quieres que esta lista sea autoincremental.
			</div>
			</div>
		</md-input-container>

	<md-card flex class="no-margin-top">
		<md-table-container class="border-bottom">

			<div class="md-title margin-right-20">
				Listas
			</div>
			<table md-table>
				<thead md-head>
					<tr md-row>
						<th md-column></th>
						<th md-column>Código</th>
						<th md-column>Descripción</th>
						<th md-column>opción 1</th>
						<th md-column>opción 2</th>
						<th md-column>opción 3</th>
						<th md-column>opción 4</th>
						<th md-column>opción 5</th>
					</tr>
				</thead>
				<tbody md-body>
					<tr md-row ng-repeat="C in Lista.listadetalle"> 
						<td md-cell>
							<!--<md-button class="md-icon-button" ng-click="editarLista(C)">
								<md-icon md-font-icon="fa-edit"></md-icon>
							</md-button>-->
							<md-button class="md-icon-button md-warn" ng-click="eliminarLista(C)">
								<md-icon md-font-icon="fa-trash"></md-icon>
							</md-button>
						</td>
						<td md-cell><input ng-if="!autoincremental" type="text" ng-model="C.codigo" style="width : 35px; heigth : 1px">
						<label ng-if="autoincremental">@{{C.codigo}}</label>
						</td>
						<td md-cell><input type="text" ng-model="C.descripcion" style="width : 80px; heigth : 1px"></td>
						<td md-cell><input type="text" ng-model="C.op1" style="width : 40px; heigth : 1px"></td>
						<td md-cell><input type="text" ng-model="C.op2" style="width : 40px; heigth : 1px"></td>
						<td md-cell><input type="text" ng-model="C.op3" style="width : 40px; heigth : 1px"></td>
						<td md-cell><input type="text" ng-model="C.op4" style="width : 40px; heigth : 1px"></td>
						<td md-cell><input type="text" ng-model="C.op5" style="width : 40px; heigth : 1px"></td>						
					</tr>
				</tbody>
			</table>
		</md-table-container>
	</md-card>

        


	</div>

	<div layout class="border-top">
		<span flex></span>
		<md-button class="md-raised md-primary" ng-click="addListadetalle()">
			<md-icon md-font-icon="fa-save"></md-icon>Nuevo
		</md-button>
		<md-button class="md-raised md-primary" ng-click="guardarLista()">
			<md-icon md-font-icon="fa-save"></md-icon>Guardar
		</md-button>
	</div>

</md-dialog>