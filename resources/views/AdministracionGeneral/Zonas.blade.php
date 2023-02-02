<div id="GestionZonas" ng-controller="ZonasCtrl" flex layout=column>
	
	<div layout class="padding-0-10" layout-align="center center">
		<div class="md-title">Gestion de Zonas</div>
		<span flex></span>

		<md-button class="md-raised md-primary" aria-label="Nuevo" ng-click="nuevaZona()">
			<md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon>Agregar Zona Agroambiental
		</md-button>
	</div>

	<div class="padding-0-10" layout flex layout-align="center" >
		<div layout=column class="padding-10-10">
				<md-card layout=column class="no-margin-top mxw230">
				<div class="padding-20" layout=column>
					<label>Filtros de búsqueda</label>
					<md-input-container>
						<label>Descripción</label>
						<input ng-change="filterZona()" type="text" ng-model="filterDescripcion" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>

					<md-input-container>
						<label>Linea Productiva</label>
						<input ng-change="filterZona()" type="text" ng-model="filterLineaProductiva" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>


				</div>
			</md-card>
		</div>


		<md-card flex class="no-margin-top">
			<md-table-container class="border-bottom">
				<table md-table>
					<thead md-head>
						<tr md-row>
							<th md-column>Acción</th>
							<th md-column>Descripción</th>
							<th md-column>Linea Productiva</th>
							<th md-column>Temperatura Min </th>
							<th md-column>Temperatura Max </th>
							<th md-column>Humedad Relativa Min </th>
							<th md-column>Humedad Relativa Max</th>
							<th md-column>Precipitación Min</th>
							<th md-column>Precipitación Max</th>
							<th md-column>Altimetria Min </th>
							<th md-column>Altimetria Max</th>
							<th md-column>Brillo Solar Min</th>
							<th md-column>Brillo Solar Max</th>
							<th md-column>Pendiente Min</th>
							<th md-column>Pendiente Max</th>
							
						</tr>
					</thead>
					<tbody md-body>
						<tr md-row ng-repeat="Z in ZonasCRUD.rows">
							
							<td md-cell>
								<md-button class="md-icon-button" ng-click="editarZona(Z)">
									<md-icon md-font-icon="fa-edit"></md-icon>
								</md-button>
								<md-button class="md-icon-button md-warn" ng-click="eliminarZona(Z)">
									<md-icon md-font-icon="fa-trash"></md-icon>
								</md-button>
							</td>
							<td md-cell>@{{ Z.descripcion }}</td>
							<td md-cell>@{{ Z.linea_productiva.nombre }}</td>
							<td md-cell>@{{ Z.temperatura_min }} <span>C°</span></td>
							<td md-cell>@{{ Z.temperatura_max }} <span>C°</span></td>
							<td md-cell>@{{ Z.humedad_relativa_min }} <span>%</span></td>
							<td md-cell>@{{ Z.humedad_relativa_max }} <span>%</span></td>
							<td md-cell>@{{ Z.precipitacion_min }} <span>Mm</span></td>
							<td md-cell>@{{ Z.precipitacion_max }} <span>Mm</span></td>
							<td md-cell>@{{ Z.altimetria_min }} <span>Mt</span></td>
							<td md-cell>@{{ Z.altimetria_max }} <span>Mt</span></td>
							<td md-cell>@{{ Z.brillo_solar_min }} <span>H</span></td>
							<td md-cell>@{{ Z.brillo_solar_max }} <span>H</span></td>
							<td md-cell>@{{ Z.pendiente_min }} <span>H</span></td>
							<td md-cell>@{{ Z.pendiente_max }} <span>H</span></td>
						</tr>
					</tbody>
				</table>
			</md-table-container>
		</md-card>
	</div>
</div>
