<md-dialog aria-label="Dialog" flex="100">
	<md-toolbar class="md-short">
		<div class="md-toolbar-tools">
			<h2>Registrar Pago</h2>
			<span flex></span>
			<md-button class="md-icon-button" ng-click="Cancel()">
				<md-icon md-svg-icon="md-close" aria-label="Cerrar Dialogo"></md-icon>
			</md-button>
		</div>
	</md-toolbar>

	<form name="Credit_Form" ng-submit="SavePago()" class="no-padding-top">
	<md-dialog-content layout>
		<div class="md-dialog-content padding" flex>
			
			<div layout="column" layout-gt-xs="row">

				<div flex="50" layout="column" class="padding">
					
					<div layout="row">
						<md-input-container flex="60">
							<input ng-model="Pago.Valor" class="md-headline" ui-money-mask="0" required min="0" max="@{{ CredSel.pago_total }}" placeholder="Valor" 
							ng-model-options="{ debounce: 300 }">
						</md-input-container>
						<md-button flex="40" ng-show="Pago.Valor < CredSel.pago_total" class="md-raised"
							ng-click="Pago.Valor = CredSel.pago_total">
							Pago Total: @{{ CredSel.pago_total | currency:'$':0 }}
						</md-button>
					</div>
					<div layout="column">
						<!--<div class="md-input-container" ng-if="Parent.Vars.OP_CAMBIAR_FECHA_PAGO">//-->
						<div >
							<label>Fecha de pago</label>
							<md-datepicker class="md-no-button" ng-model="Pago.Fecha"></md-datepicker>
						</div>
					</div>


					<div layout>
						<md-input-container flex>
							<label>Medio</label>
							<md-select ng-model="Pago.Medio">
								<md-option ng-repeat="Op in ['Efectivo', 'Consignación']" ng-value="Op">@{{Op}}</md-option>
							</md-select>
						</md-input-container>

						<md-input-container flex ng-if="Pago.Medio == 'Consignación' ">
							<input ng-model="Pago.NoConsignacion" placeholder="No. de Consignación" ng-required="Pago.Medio == 'Consignación'">
						</md-input-container>
					</div>

					<div layout>
						<md-input-container flex>
							<label>Sobrante</label>
							<md-select ng-model="Pago.SobranteOp">
								<md-option ng-repeat="(k,Op) in SobranteOps" ng-value="k">@{{Op}}</md-option>
							</md-select>
						</md-input-container>
					</div>
					
				</div>

				<div flex="50" ng-hide="Pagos.length == 0">

					<span class="md-title">Simulación de Pagos</span>
					<md-table-container class="md-table-short table-nowrap" flex>
					<table md-table>
						<thead md-head>
							<tr md-row>
								<th md-column>No Cuota</th>
								<th md-column md-numeric>Valor</th>
								<th md-column>Paga</th>
								<th md-column>Tipo</th>
							</tr>
						</thead>
						<tbody md-body>
							<tr md-row ng-repeat="Pago in Pagos" class="md-row-hover">
								<td md-cell class="md-cell-compress text-center">@{{ Pago.NoCuota }}</td>
								<td md-cell class="md-cell-compress">@{{ Pago.Valor | currency:"$":0 }}</td>
								<td md-cell class="md-cell-compress">@{{ Pago.Paga }}</td>
								<td md-cell>@{{ Pago.Tipo }}</td>
							</tr>
						</tbody>
					</table>
					</md-table-container>

				</div>

			</div>

			<md-divider></md-divider>
			<p class="md-title">Simulación de Cuotas</p>
			@include('FondoRotatorio.Creditos_CreditList_Cuotas')
			
			<div ng-if="Pago.AbonadoCapital > 0">
				<md-divider></md-divider>
				<p class="md-title">Abonado a Capital: @{{ Pago.AbonadoCapital | currency:"$":0 }} -> Refinanciando: @{{ Deuda | currency:"$":0 }}</p>
				@include('FondoRotatorio.Creditos_Amortable')
			</div>


			<p class="md-headline text-center" ng-if="Deuda <= 0">Crédito pagado en su totalidad</p>

			<p class="md-headline text-center" ng-show="Pago.Devolver > 0">Devolver: @{{ Pago.Devolver | currency:"$":0 }}</p>

		</div>
	</md-dialog-content>

	<md-dialog-actions layout>
		<md-button class="md-dialog-button-left" ng-click="Cancel()">Cancelar</md-button>
		<span flex></span>
		<md-button type="submit" class="md-raised md-primary" ng-disabled="Pagos.length == 0">Registrar Pago</md-button>
	</md-dialog-actions>
	</form>
</md-dialog>