<div id="FondoRotatorio_Listado" flex layout=column ng-controller="FondoRotatorio_ListadoCtrl">
	
	<div layout class="padding-0-10 h40" layout-align="center center">
		<div class="md-title margin-right-20">Listado de Créditos</div>
		<span flex></span>
	</div>

	<md-card flex class="no-margin-top">
		<md-table-container class="border-bottom">
			<table md-table>
				<thead md-head>
				<tr md-row>
					<th md-column></th>
					<th md-column md-numeric>Cod.</th>
					<th md-column>Documento</th>
					<th md-column>Nombre</th>
					<th md-column>Estado</th>
					<th md-column>Línea</th>
					<th md-column md-numeric>Monto</th>
					<th md-column md-numeric>Interés</th>
					<th md-column>Pagos</th>
					<th md-column md-numeric>Periodos</th>
					<th md-column md-numeric>Periodos Gracia</th>
					<th md-column md-numeric>Cuota</th>
					<th md-column md-numeric>Saldo</th>
					<th md-column>Creado</th>
					<th md-column>Usuario</th>
				</tr>
				</thead>
				<tbody md-body>
				<tr md-row ng-repeat="C in CreditosCRUD.rows">
					<td md-cell><md-button class="md-icon-button" ng-click="printCredit(C, $event)">
						<md-icon md-font-icon="fa-print"></md-icon>
					</md-button></td>
					<td md-cell class="md-cell-compress">@{{ C.id }}</td>
					<td md-cell class="md-cell-compress">@{{ C.afiliado.tipo_documento +':'+ C.afiliado.documento }}</td>
					<td md-cell class="md-cell-compress">@{{ C.afiliado.nombre }}</td>
					<td md-cell class="md-cell-compress" ng-style="{ color: C.estado_color }" class="text-bold">@{{ C.estado }}</td>
					<td md-cell class="md-cell-compress">@{{ C.linea }}</td>
					<td md-cell class="md-cell-compress">@{{ C.monto | currency:'$':0 }}</td>
					<td md-cell class="md-cell-compress">@{{ C.interes }}%</td>
					<td md-cell class="md-cell-compress">@{{ C.pagos }}</td>
					<td md-cell class="md-cell-compress">@{{ C.periodos }}</td>
					<td md-cell class="md-cell-compress">@{{ C.periodos_gracia }}</td>
					<td md-cell class="md-cell-compress">@{{ C.cuota | currency:'$':0 }}</td>
					<td md-cell class="md-cell-compress">@{{ C.saldo | currency:'$':0 }}</td>
					<td md-cell class="md-cell-compress">@{{ C.created_at | date:'medium' }}</td>
					<td md-cell class="md-cell-compress">@{{ C.usuario.nombre }}</td>
				</tr>
				</tbody>
			</table>
		</md-table-container>
	</md-card>

</div>