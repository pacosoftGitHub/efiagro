<md-table-container class="md-table-short table-nowrap table-col-compress" flex>
	<table md-table>
		<thead md-head>
			<tr md-row>
				<th md-column md-numeric>Cod.</th>
				<th md-column>Fecha</th>
				<th md-column>Medio</th>
				<th md-column>No. Consignación</th>
				<th md-column md-numeric>Valor</th>
			</tr>
		</thead>
		<tbody md-body>
			<tr md-row ng-repeat="Recibo in CredSel.recibos" class="md-row-hover">
				<td md-cell class="md-cell-compress">@{{ Recibo.id }}</td>
				<td md-cell>@{{ Recibo.fecha }}</td>
				<td md-cell>@{{ Recibo.medio }}</td>
				<td md-cell>@{{ Recibo.no_consignacion }}</td>
				<td md-cell>@{{ Recibo.valor | currency:"$":0 }}</td>
			</tr>
		</tbody>
	</table>
</md-table-container>