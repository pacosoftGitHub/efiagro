<md-table-container id="Amortable" flex ng-show="Amortable.length > 0" class="md-table-short table-nowrap">
	<table md-table>
		<thead md-head>
			<tr md-row>
				<th md-column>#</th>
				<th md-column>Fecha</th>
				<th md-column>Capital</th>	
				<th md-column>Interés</th>
				<th md-column>Total</th>
				<th md-column>Deuda</th>
			</tr>
		</thead>
		<tbody md-body>
			<tr md-row ng-repeat="Mort in Amortable">
				
				<td md-cell>@{{ Mort.Num_Pago }}</td>
				<td md-cell><nobr>@{{ Mort.Fecha }}</nobr></td>
				<td md-cell>@{{ Mort.Capital | currency:"$":0 }}</td>
				<td md-cell>@{{ Mort.Interes | currency:"$":0 }}</td>
				<td md-cell>@{{ Mort.Total   | currency:"$":0 }}</td>
				<td md-cell>@{{ Mort.Deuda  | currency:"$":0 }}</td>

			</tr>
		</tbody>
		<tfoot md-foot ng-show="Amortable.length > 1">
			<tr md-row>
				<td md-cell></td>
				<td md-cell></td>
				<td md-cell><b> @{{ AmortableRes.Capital | currency:"$":0 }} </b></td>
				<td md-cell><b> @{{ AmortableRes.Interes | currency:"$":0 }} </b></td>
				<td md-cell><b> @{{ AmortableRes.Total 	| currency:"$":0 }} </b></td>
				<td md-cell><b> @{{ AmortableRes.Deuda   | currency:"$":0 }} </b></td>
				
			</tr>
		</tfoot>
	</table>
</md-table-container>