<div id="GestionCasos" ng-controller="CasosCtrl" flex layout=column>
	
	<div layout class="padding-0-10" layout-align="center center">
		<div class="md-title">Gestion de Casos</div>
		<span flex></span>
		<md-button class="md-raised md-primary" aria-label="Nuevo" ng-click="nuevoCaso()">
			<md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon>Agregar Casos
		</md-button>
	</div>

	<div class="padding-0-10" layout flex layout-align="center" >
		<div layout=column class="padding-10-10">
				<md-card layout=column class="no-margin-top mxw230">
				<div class="padding-20" layout=column>
					<label>Filtros de búsqueda</label>

					<mat-form-field appearance="fill">
						<md-select ng-model="filterTipo" ng-change="filterCaso()" placeholder="Tipo de caso">
							<md-option ng-value="tc">
								Todos los casos
							</md-option>
							<md-option ng-repeat="tc in tiposCasos" ng-value="tc">
								@{{tc}}
							</md-option>
						</mat-select>
					</mat-form-field>

					<md-input-container>
						<label>Asociado</label>
						<input ng-change="filterCaso()" type="text" ng-model="filterAsociado" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>

					<md-input-container>
						<label>Quién lleva el caso</label>
						<input ng-change="filterCaso()" type="text" ng-model="filterLlevacaso" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>
					</div>
				</md-card>
		</div>

		<md-card flex class="no-margin-top">
		<md-table-container class="border-bottom">
		<table md-table>
			<thead md-head>
			<tr md-row>
				<th md-column></th>
				<th md-column>Tipo</th>
				<th md-column>Titulo</th>
				<th md-column>Asociado</th>
				<th md-column>Actualizado</th>
			</tr>
			</thead>
			<tbody md-body>
			<tr md-row ng-repeat="C in Casoscopy">
				<td md-cell>
					<md-button class="md-icon-button" ng-click="editarCaso(C)">
						<md-icon md-font-icon="fa-edit"></md-icon>
					</md-button>
					<md-button class="md-icon-button text-ocean" ng-click="novedadesCaso(C)">
						<md-icon md-font-icon="fa-align-justify"></md-icon>
					</md-button>
				</td>
				<td md-cell>@{{ C.tipo }}</td>
				<td md-cell>@{{ C.titulo }}</td>
				<td md-cell>@{{ C.solicitante.nombre }}</td>
				<td md-cell>@{{ C.updated_at | date:'yyyy-MM-dd' }}</td>
			</tr>
			</tbody>
		</table>
		</md-table-container>
		</md-card>
	</div>
</div>
