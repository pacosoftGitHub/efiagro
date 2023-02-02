<md-dialog  aria-label="Dialog" flex="95" style="max-height: 100vh;" layout=column>
	<md-toolbar class="md-short bg-primary">
		<div class="md-toolbar-tools">
			<h2>@{{ Title }}</h2>
			<span flex></span>
			<md-button class="md-icon-button" ng-click="Cancelar()">
				<md-icon md-svg-icon="md-close" aria-label="Cerrar Dialogo"></md-icon>
			</md-button>
		</div>
	</md-toolbar>

	<form flex layout=column id="Credit_Print" name="Credit_Form" ng-submit="SaveCredit()" layout-padding class="no-padding-top no-padding-bottom">
	<md-dialog-content flex  layout="column" layout-gt-xs="row" class="no-overflow">

		<div flex="30" layout layout-wrap layout-align="start start" class="not-on-print mw290 mxw400">
		
			<md-input-container class="md-icon-float" flex="100">
				<input class="md-display-1 monto" ng-model="Credit.Monto" required type="string" placeholder="Monto" ui-money-mask="0" min="0">
			</md-input-container>

			<md-input-container flex="100" ng-if="!Simulate">
				<label>Línea</label>
				<md-select ng-model="Credit.Linea" aria-label="Linea" >
					<md-option ng-repeat="L in Lineas" ng-value="L">@{{ L }}</md-option>
				</md-select>
			</md-input-container>

			<md-input-container flex="50">
				<input ng-model="Credit.Interes" required type="string" min="0" placeholder="Interés (EA)" ui-percentage-mask ng-readonly="@{{ !Parent.Vars.CREDITO_CAMBIAR_INTERES }}">
			</md-input-container>

			<md-input-container flex="50">
				<label>Pagos</label>
				<md-select ng-model="Credit.Cada" aria-label="Scale" >
					<md-option ng-repeat="(k, Scale) in Scales" ng-value="Scale">@{{ Scale.Nombre }}</md-option>
				</md-select>
			</md-input-container>

			<md-input-container flex="50">
				<input ng-model="Credit.Periodos" required type="number" step="1" min="1" placeholder="Periodos Totales">
			</md-input-container>

			<md-input-container flex="50">
				<input ng-model="Credit.Periodos_Gracia" required type="number" step="1" min="0" max="@{{ Credit.Periodos - 1 }}" placeholder="Periodos de Gracia">
			</md-input-container>

			<md-input-container flex=100 ng-if="Parent.Vars.CREDITO_CAMBIAR_FECHA && !Simulate">
				<label>Inicio</label>
				<md-datepicker class="md-no-button" ng-model="Credit.Primer_Pago"></md-datepicker>
			</md-input-container>
			
			<span flex="100" class="md-headline text-center" ng-if="Credit.Cuota > 0">Cuota: @{{ Credit.Cuota | currency:'$':0 }}</span>
			

		</div>

		<div flex="70" layout="column" class="padding-left overflow-x">
			
			<div class="only-on-print">
				<h4 class="md-headline no-margin">Simulación de Crédito</h4>
				<span class="md-title text-clear" layout>Fecha: @{{ Hoy }}</span>
				<p class="md-subhead"><b>Monto:</b> @{{ Credit.Monto | currency:'$':0 }} 
					<br><b>Pago:</b> @{{ Credit.Periodos }} pagos @{{ Credit.Cada.Nombre }}
					<br><b>Interés (E.A.):</b> @{{ Credit.Interes * 100 }}% 
					<br><b>Cuota:</b> @{{ Credit.Cuota | currency:'$':0 }}.
				</p>
			</div>

			<div  flex layout>
				@include('FondoRotatorio.Creditos_Amortable')
			</div>


		</div>

		<style type="text/css">
			#Amortable{     max-height: 60vh;  }
			#Amortable tbody tr{ height: 30px; }
		</style>

	</md-dialog-content>

	<md-dialog-actions layout class="no-padding not-on-print">
		<md-button class="md-dialog-button-left" ng-click="Cancelar()">Cancelar</md-button>
		<span flex></span>
		<md-button print-this="#Credit_Print" ng-class="{ 'md-raised' : Simulate }"><md-icon md-font-icon="fa-print" class="fa-fw margin-right"></md-icon>Imprimir</md-button>
		<md-button type="submit" ng-if="!Simulate" ng-disabled="Amortable.length == 0" class="md-raised md-accent">Registrar Crédito</md-button>
	</md-dialog-actions>
	</form>
</md-dialog>

<style>
@media only screen and (max-width: 960px) {
  .monto {
    font-size: 25px !important;
  }
}
</style>