<div id="GestionFincaEventos" ng-controller="FincaEventosCtrl" flex layout=column>
	
	<div layout class="padding-0-10" layout-align="center center">
		<div class="md-title">Eventos Reportados</div>
		<span flex></span>

		<md-input-container class="no-margin md-icon-float" md-no-float>
			<md-icon md-font-icon="fa-search fa-fw"></md-icon>
			<input type="text" ng-model="filterEventos" placeholder="Buscar...">
		</md-input-container>
		
		<span flex></span>
	</div>

	<div class="padding-0-10" layout flex layout-align="center" >
		<div layout=column class="padding-10-10">
			<md-card layout=column class="no-margin-top mxw230">
				<div class="padding-20" layout=column>
					<label>Filtros de búsqueda</label>

					<md-input-container>
						<label>Finca</label>
						<input ng-change="filterFincaEvento()" type="text" ng-model="filterFinca" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>

                    <md-input-container>
						<label>Evento</label>
						<input ng-change="filterFincaEvento()" type="text" ng-model="filterEvento" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
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
							<th md-column>Finca</th>
							<th md-column>Evento</th>
							<th md-column>Fecha</th>
							<th md-column>Gravedad</th>
							<th md-column>Observación/Reporte</th>		
						</tr>
					</thead>
					<tbody md-body>
						<tr md-row ng-repeat="FE in FincaEventosCRUD.rows">
							<td md-cell>
								<md-button class="md-icon-button" ng-click="editarEvento(FE)">
									<md-icon md-font-icon="fa-edit"></md-icon>
								</md-button>
								<md-button class="md-icon-button md-warn" ng-click="eliminarEvento(FE)">
									<md-icon md-font-icon="fa-trash"></md-icon>
								</md-button>
							</td>
							<td md-cell>@{{ FE.finca.nombre }}</td>
							<td md-cell>@{{ FE.evento.evento }}</td>
							<td md-cell>@{{ FE.fecha | date:'yyyy-MM-dd'}} </td> 
							<td md-cell>@{{ FE.gravedad }} </td> 
							<td md-cell>@{{ FE.observacion }} </td> 		
						</tr>
					</tbody>
				</table>
			</md-table-container>
		</md-card>
</div>
