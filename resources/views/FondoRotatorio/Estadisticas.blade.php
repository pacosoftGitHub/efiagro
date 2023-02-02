<div id="FondoRotatorio_Estadisticas" flex layout="column"
	ng-controller="FondoRotatorio__EstadisticasCtrl">

	<div id="Estadisticas__TopBar" class="md-whiteframe-3dp bg-white h50" layout layout-wrap>

		<md-select ng-model="RepId" ng-change="SelectRep()" aria-label="Selector" class="no-margin h50">
			<md-option ng-repeat="Rep in Reps" ng-value="Rep" ng-selected="$first" ng-value="Rep.id">
				<md-icon md-font-icon="@{{ Rep.Icon }}" class="fa-fw"></md-icon>
				@{{ Rep.Titulo }}
			</md-option>
		</md-select>

		<div id="Estadisticas__Filters" flex layout layout-wrap>
			@include('FondoRotatorio.Estadisticas_Filters')
			<span flex></span>
			<md-button hide class="md-icon-button no-margin" print-this="#Estadisticas__Sections" aria-label="Imprimir">
				<md-icon md-font-icon="fa-print" class="fa-lg"></md-icon>
			</md-button>
			<md-button class="md-raised md-accent" ng-click="Load()">Cargar</md-button>
		</div>

	</div>

	<div id="Estadisticas__Sections" flex class="overflow" layout layout-wrap layout-align="center start">
		<div class="Section container" ng-repeat="(k,S) in RepSel.sections" flex="100" flex-gt-sm="@{{S.Width}}">
			<md-progress-circular class="md-accent" md-diameter="80" ng-if="!S.Loaded" md-mode="indeterminate"></md-progress-circular>
			<ng-include src="S.L.Template" ng-if="S.Loaded" id="Estadisticas_Section_@{{ S.id }}"></ng-include>
		</div>
		<pre hide>@{{ RepSel.sections | json }}</pre>
	</div>

</div>