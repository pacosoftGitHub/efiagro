<md-dialog md-theme="default" aria-label="Dialog" class="mw720 vh100" layout="column">
	<md-toolbar class="md-short bg-primary">
		<div class="md-toolbar-tools">
			<h2>@{{ Title }}</h2>
			<span flex></span>
			<md-button class="md-icon-button" ng-click="Cancel()">
				<md-icon md-svg-icon="md-close" aria-label="Cerrar Dialogo"></md-icon>
			</md-button>
		</div>
	</md-toolbar>

	<md-dialog-content flex layout>
		<div id="Credito__Recibo_Print" class="md-dialog-content padding overflow" 
			ng-class="{ 'conCopia': ConCopia }" flex>
			
			@include('FondoRotatorio.Creditos_CreditoDialog_Receit')
					
		</div>
	</md-dialog-content>

	<md-dialog-actions class="border-top" layout>
		<md-button class="md-dialog-button-left" ng-click="Cancel()">Cancelar</md-button>
		<span flex></span>
		<md-switch hide ng-model="ConCopia" aria-label="Swtch">Con copia</md-switch>
		<md-button class="md-raised md-primary" print-this="#Credito__Recibo_Print">Imprimir</md-button>
	</md-dialog-actions>
	</form>
</md-dialog>