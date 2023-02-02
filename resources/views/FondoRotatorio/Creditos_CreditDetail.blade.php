<div id="CreditDetail" flex layout="column" ng-hide="CredSel == null" class="overflow-y">

	<md-card id="CredSelDetails" class="Cred">
		@include('FondoRotatorio.Creditos_CreditCard')
	</md-card>

	<md-card flex class="no-margin-top">
		<md-tabs md-border-bottom flex class="md-tabs-fullheight">

			<md-tab label="Cuotas">
				<md-content layout="column">
					<div layout=column flex>
						@include('FondoRotatorio.Creditos_CreditList_Cuotas')
					</div>

					<div layout ng-show="CredSel.estado !== 'Terminado' ">
						<span flex></span>
						<md-button aria-label="Pagar" class="md-raised md-primary bg-primary"
							ng-click="NewAbono($event)">
							<md-icon md-font-icon="fa-plus" class="margin-right-5"></md-icon>
							Agregar Pago
						</md-button>
					</div>

				</md-content>
			</md-tab>

			<md-tab label="Pagos">
				<md-content layout="column" class="well"  layout-align="start center">
					@include('FondoRotatorio.Creditos_CreditList_Pagos')
					<div class="mh50"></div>
				</md-content>
			</md-tab>

			<!--<md-tab label="Bitácora">
				<md-content layout class="well padding-left padding-right"  layout-align="center start">
					include('FondoRotatorio.Creditos_Comments')
				</md-content>
			</md-tab>-->

		</md-tabs>
	</md-card>

</div>