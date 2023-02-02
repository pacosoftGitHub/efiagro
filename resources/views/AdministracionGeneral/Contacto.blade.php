<!--INICIO DEV ANGELICA-->
<div id="GestionContacto" ng-controller="ContactoCtrl" flex layout=column>

<br>
<div layout class="padding-0-10" layout-align="center center">
	<div class="md-title margin-right-20">Control de Contacto</div>
        <span flex></span>
        <md-button class="md-raised md-primary" aria-label="Nuevo" ng-click="nuevoContacto()">
			<md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon>Agregar Contacto
		</md-button>

	</div>
    <br>
	<div class="padding-0-10" layout flex layout-align="center" >
		<div layout=column class="padding-10-10">
				<md-card layout=column class="no-margin-top mxw230">
				<div class="padding-20" layout=column>
					<label>Filtros de búsqueda</label>
					<md-input-container>
						<label>Tipo</label>
						<input ng-change="filterContacto()" type="text" ng-model="filterTipo" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>

					<md-input-container>
						<label>Asociado</label>
						<input ng-change="filterContacto()" type="text" ng-model="filterAsociado" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
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
					{{-- <th md-column>Caso</th> --}}
					<th md-column>Tipo</th>
					<th md-column>Titulo</th>
					<th md-column>Asociado</th>
					<th md-column>Creado</th>
					<th md-column>Actualizado</th>
				</tr>
				</thead>
				<tbody md-body>
				<tr md-row ng-repeat="C in ContactoCRUD.rows">
					<td md-cell>
						<md-button class="md-icon-button" ng-click="editarContacto(C)">
							<md-icon md-font-icon="fa-edit"></md-icon>
						</md-button>
						<md-button class="md-icon-button md-warn" ng-click="eliminarContacto(C)">
							<md-icon md-font-icon="fa-trash"></md-icon>
						</md-button>
					</td>
					{{-- <td md-cell>@{{ C.id }}</td> --}}
					<td md-cell>@{{ C.tipo }}</td>
					<td md-cell>@{{ C.titulo }}</td>
					<td md-cell>@{{ C.solicitante.nombre }}</td>
					<td md-cell>@{{ C.created_at | date:'yyyy-MM-dd'}}</td>
					<td md-cell>@{{ C.updated_at | date:'yyyy-MM-dd'}}</td>
				</tr>
				</tbody>
			</table>
			</md-table-container>
		</md-card>
	</div>
</div>

<!--FIN DEV ANGELICA-->