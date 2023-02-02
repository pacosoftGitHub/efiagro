<md-table-container class="md-table-short table-nowrap table-col-compress" flex>
	<table md-table>
		<thead md-head>
			<tr md-row>
				<th md-column></th>
				<th md-column>Estado</th>
				<th md-column md-numeric>No.</th>
				<th md-column>Fecha</th>
				<th md-column md-numeric>Capital</th>
				<th md-column md-numeric>Interés</th>
				<th md-column md-numeric>In. Causados<md-tooltip>Interes Causados</md-tooltip></th>
				<th md-column md-numeric>Cuota</th>
				<th md-column md-numeric>Deuda</th>
				<th md-column md-numeric>Abonado</th>
				<th md-column md-numeric>Pendiente</th>
				<th md-column md-numeric>Mora</th>
				<th md-column md-numeric>Días Mora</th>
			</tr>
		</thead>
		<tbody md-body>
			<tr md-row ng-repeat="Cuota in CredSel.saldos" class="md-row-hover">
				<td md-cell class="text-center" ng-style="{ color: Cuota.estado_color }">
					<md-icon ng-if="Cuota.estado == 'Pendiente' "         		md-font-icon="far fa-circle fa-lg fa-fw"></md-icon>
					<md-icon ng-if="Cuota.estado == 'Pagado' "            		md-font-icon="fa-check fa-lg fa-fw"></md-icon>
					<md-icon ng-if="Cuota.estado == 'Pendiente Pago Parcial' "  md-font-icon="fa-flag fa-lg fa-fw"></md-icon>
					<md-icon ng-if="Cuota.estado == 'Mora' "              		md-font-icon="fa-exclamation-circle fa-lg fa-fw"></md-icon>
					<md-icon ng-if="Cuota.estado == 'Mora Pago Parcial' " 		md-font-icon="fa-exclamation fa-lg fa-fw"></md-icon>
				</td>
				<td md-cell ng-style="{ color: Cuota.estado_color }"><b>@{{ Cuota.estado  }}</b></td>
				<td md-cell class="nowrap">@{{ Cuota.num_pago}}</td>
				<td md-cell class="nowrap">@{{ Cuota.date   }}</td>
				<td md-cell class="nowrap">@{{ Cuota.capital | currency:"$":0 }}</td>
				<td md-cell class="nowrap">@{{ Cuota.interes | currency:"$":0 }}</td>
				<td md-cell class="nowrap">@{{ Cuota.interes_causado | currency:"$":0 }}</td>
				<td md-cell class="nowrap">@{{ Cuota.total   | currency:"$":0 }}</td>
				<td md-cell class="nowrap">@{{ Cuota.deuda   | currency:"$":0 }}</td>
				<td md-cell class="nowrap">@{{ Cuota.abonado | currency:"$":0 }}</td>
				<td md-cell class="nowrap">@{{ Cuota.pendiente | currency:"$":0 }}</td>
				<td md-cell class="nowrap">@{{ Cuota.mora   | currency:"$":0 }}</td>
				<td md-cell class="nowrap">@{{ Cuota.dias_mora  }}</td>
			</tr>
		</tbody>
		<tfoot md-foot>
			<tr md-row class="md-row-hover text-bold border-bottom">
				<td md-cell></td>
				<td md-cell></td>
				<td md-cell class="nowrap"></td>
				<td md-cell class="nowrap"></td>
				<td md-cell class="nowrap">@{{ CredSel.saldos | sum:'capital' | currency:"$":0 }}</td>
				<td md-cell class="nowrap">@{{ CredSel.saldos | sum:'interes' | currency:"$":0 }}</td>
				<td md-cell class="nowrap">@{{ CredSel.saldos | sum:'interes_causado' | currency:"$":0 }}</td>
				<td md-cell class="nowrap"></td>
				<td md-cell class="nowrap"></td>
				<td md-cell class="nowrap">@{{ CredSel.saldos | sum:'abonado' | currency:"$":0 }}</td>
				<td md-cell class="nowrap">@{{ CredSel.saldos | sum:'pendiente' | currency:"$":0 }}</td>
				<td md-cell class="nowrap"></td>
				<td md-cell class="nowrap"></td>
			</tr>
		</tfoot>
	</table>
</md-table-container>