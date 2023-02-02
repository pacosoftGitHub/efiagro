<div id="GestionArticulos" ng-controller="ArticulosCtrl" flex layout=column>
	
	<div layout class="padding-0-10" layout-align="center center">
		<div class="md-title">Repositorio de Conocimiento</div>
		<span flex></span>
		<md-button class="md-raised md-primary" aria-label="Nuevo" ng-click="nuevoArticulo()">
			<md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon> Agregar Articulo
		</md-button>
	</div>

	<div class="padding-0-10" layout flex layout-align="center" >
		<div layout=column class="padding-10-10">
			<md-card layout=column class="no-margin-top mxw230">
				<div class="padding-20" layout=column>
						
					<label>Filtros de búsqueda</label>
						
					<mat-form-field appearance="fill">
					
					<md-input-container>
						<label>Lineas productivas</label>
							<md-select ng-model="idLineaproductiva" ng-change="filterArticulos()" placeholder="Línea Productiva">
								<md-option ng-value="lp">
									Todos las líneas
								</md-option>
								<md-option ng-repeat="lp in lineas_productivas" ng-value="lp.id">
									@{{lp.nombre}}
								</md-option>
							</mat-select>
						</mat-form-field>
					</md-input-container>

					<md-input-container>
						<label>Título</label>
						<input ng-change="filterArticulos()" type="text" ng-model="filterTitulo" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>

					{{-- <md-input-container>
						<label>Palabras clave</label>
						<md-chips md-on-add="filterArticulos()" md-on-remove="filterArticulos()" ng-model="filterKeys" readonly="readonly" md-removable="removable">
						</md-chips>
					</md-input-container> --}}

					<md-input-container>
						<label>Autor</label>
						<input ng-change="filterArticulos()" type="text" ng-model="filterAutor" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>
				</div>
			</md-card>
		</div>
		<!--FIN DEV ANGÉLICA-->

		<md-card flex class="no-margin-top">
		<md-table-container class="border-bottom">
		<table md-table>
			<thead md-head>
			<tr md-row>
				<th md-column></th>
				<th md-column>Titulo</th>
				<th md-column>Autor</th>
				<th md-column>Creado</th>
				<th md-column>Actualizado</th>
				<th md-column>Estado</th>
			</tr>
			</thead>
			<tbody md-body>
			<tr md-row ng-repeat="A in ArticulosCRUD.rows">
				<td md-cell><md-button class="md-icon-button" ng-click="editarArticulo(A)">
					<md-icon md-font-icon="fa-edit"></md-icon>
				</md-button></td>
				<td md-cell>@{{ A.titulo }}</td>
				<td md-cell>@{{ A.autor.nombres }}</td>
				<td md-cell>@{{ A.created_at | date:'yyyy-MM-dd'}}</td>
				<td md-cell>@{{ A.updated_at | date:'yyyy-MM-dd'}}</td>
				<td md-cell>@{{ A.estado}}</td>
			</tr>
			</tbody>
		</table>
		</md-table-container>
		</md-card>
	</div>
</div>








