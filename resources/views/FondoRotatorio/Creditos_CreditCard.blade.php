<md-card-title class="padding">
	<md-card-title-text layout layout-wrap ng-style="{ color: CredSel.estado_color }" >
		<span class="md-title margin-right w110">Cod. @{{ CredSel.id }}</span>
		<span class="md-title margin-right w150">@{{ CredSel.estado }}</span>
		<span class="md-title">@{{ CredSel.linea }}</span>
		<span flex></span>
		<span ng-hide="CredSel.proximo_pago == null"><b>Próximo pago:</b> @{{ CredSel.proximo_pago }}</span>
	</md-card-title-text>
</md-card-title>

<md-card-content class="padding-but-top">
	
	<div class="Cred_General" layout layout-wrap>
		
		<md-input-container flex class="margin-bottom-5 md-no-underline mw110">
			<label>Monto</label>
			<input type="text" ng-model="CredSel.monto" ng-readonly ui-money-mask=0>
		</md-input-container>

		<md-input-container flex class="margin-bottom-5 md-no-underline mw50">
			<label>Interes (EA) (%)</label>
			<input type="text" ng-model="CredSel.interes" ng-readonly>
		</md-input-container>

		<md-input-container flex class="margin-bottom-5 md-no-underline mw50">
			<label>Periodos</label>
			<input type="number" ng-model="CredSel.periodos" ng-readonly>
		</md-input-container>

		<md-input-container flex class="margin-bottom-5 md-no-underline mw120">
			<label>Pagos</label>
			<input type="text" ng-model="CredSel.pagos" ng-readonly>
		</md-input-container>

		<md-input-container flex class="margin-bottom-5 md-no-underline mw50">
			<label>Per. Gracia</label>
			<input type="number" ng-model="CredSel.periodos_gracia" ng-readonly>
		</md-input-container>

		<md-input-container flex class="margin-bottom-5 md-no-underline mw100">
			<label>Cuota</label>
			<input type="text" ng-model="CredSel.cuota" ng-readonly ui-money-mask=0>
		</md-input-container>

		<md-input-container flex class="margin-bottom-5 md-no-underline mw110">
			<label>Saldo</label>
			<input type="text" ng-model="CredSel.saldo" ng-readonly ui-money-mask=0>
		</md-input-container>

	</div>

</md-card-content>