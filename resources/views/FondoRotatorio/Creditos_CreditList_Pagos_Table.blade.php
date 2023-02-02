<md-table-container class="md-table-short table-nowrap" flex>
	<table md-table>
		<thead md-head>
			<tr md-row>
				<th md-column md-numeric>No. Cuota</th>
				<th md-column>Fecha Cuota</th>
				<th md-column>Valor Cuota</th>
				<th md-column>Paga</th>
				<th md-column>Tipo</th>
				<th md-column md-numeric>Valor</th>
			</tr>
		</thead>
		<tbody md-body>
			<tr md-row ng-repeat="Abono in Recibo.abonos" class="md-row-hover" ng-style="{ 'background-color': Abono.color }">
				<td md-cell class="md-cell-compress">@{{ ::Abono.saldo.num_pago   }}</td>
				<td md-cell class="md-cell-compress">@{{ ::Abono.saldo.fecha   }}</td>
				<td md-cell class="md-cell-compress">@{{ ::Abono.saldo.total | currency:"$":0 }}</td>
				<td md-cell class="md-cell-compress">@{{ ::Abono.paga   }}</td>
				<td md-cell class="md-cell-compress">@{{ ::Abono.tipo   }}</td>
				<td md-cell>@{{ ::Abono.valor | currency:"$":0 }}</td>
			</tr>
		</tbody>
	</table>
</md-table-container>
