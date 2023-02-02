<md-card ng-controller="Estadisticas__Chart_BarCtrl" ng-init="Init(k)">
	@include('FondoRotatorio.Sections.Utils.Card_Header')

	<md-card-content class="no-padding mh300">
		<nvd3 options="options" data="S.L.data" config="{deepWatch: false}" api="api" 
			class="chart-bar with-3d-shadow with-transitions">
		</nvd3>
	</md-card-content>

</md-card>