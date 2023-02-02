<div id="FondoRotatorio_MisCreditos" flex layout=column layout-align="start center" ng-controller="FondoRotatorio_MisCreditosCtrl">
	
	<md-card ng-repeat="CredSel in CreditosCRUD.rows" 
		class="Cred relative Pointer mxw850" md-ink-ripple="#000000" 
		ng-click="printCredit(CredSel)">
		@include('FondoRotatorio.Creditos_CreditCard')
	</md-card>

</div>