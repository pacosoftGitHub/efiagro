<div ng-show="!CredSel">

	<md-card ng-repeat="CredSel in Creditos" class="Cred relative Pointer" md-ink-ripple="#000000" 
		ng-click="ViewCredit(CredSel)">
		@include('FondoRotatorio.Creditos_CreditCard')
	</md-card>

	<md-button ng-click="nuevoCredito($event)"
		class="md-fab md-fab-bottom-right pos-fixed no-margin" aria-label="Nuevo Credito">
		<md-tooltip md-direction=left>Nuevo Crédito</md-tooltip>
		<md-icon md-svg-icon="md-plus"></md-icon>
	</md-button>

</div>