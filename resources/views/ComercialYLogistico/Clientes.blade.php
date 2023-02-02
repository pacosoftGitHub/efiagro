<div id="AdministracionClientes" ng-controller="ClientesCtrl" flex layout=column>
	
	<div layout class="padding-0-10" layout-align="center center">
		<div class="md-title">CLIENTES DE LA PLATAFORMA</div>
		<span flex></span>
		<md-button class="md-raised md-primary" aria-label="Nuevo" ng-click="nuevoCliente($event)">
			<md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon> Agregar Cliente
		</md-button>
	</div>

		<md-card flex class="no-margin-top">
		<md-table-container class="border-bottom">
		<table md-table>
			<thead md-head>
			<tr md-row>
				<th md-column></th>
				<th md-column>T.D</th>
				<th md-column>Número</th>
				<th md-column>Nombre Cliente</th>
				<th md-column>Correo</th>
				<th md-column>Celular</th>
				<th md-column>Tel. Fijo</th>
			</tr>
			</thead>
			<tbody md-body>
			<tr md-row ng-repeat="A in fichas">
				<td md-cell><md-button class="md-icon-button" ng-click="editarArticulo(A)">
					<md-icon md-font-icon="fa-edit"></md-icon>
				</md-button></td>
				<td md-cell>@{{ A.Producto }}</td>
				<td md-cell>@{{ A.Calidad }}</td>
				<td md-cell>@{{ A.Presentacion}}</td>
				<td md-cell>@{{ A.Volumen}}</td>
				<td md-cell>@{{ A.Frecuencia}}</td>
				<td md-cell>@{{ A.Empaque}}</td>
			</tr>
			</tbody>
		</table>
		</md-table-container>
		</md-card>
	</div>
</div>








