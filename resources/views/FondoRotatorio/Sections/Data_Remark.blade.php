<md-card ng-controller="Estadisticas__Data_RemarkCtrl" ng-init="Init(k)">
	@include('FondoRotatorio.Sections.Utils.Card_Header')

	<md-card-content layout layout-wrap layout-align="space-around center" class="no-padding Data-Remark">

		<div layout="column" class="text-center margin-bottom margin-left margin-right" ng-repeat="D in S.L.data" ng-style="{ color: D.color }">
			<span class="md-display-1">@{{ D.value }}</span>
			<span class="md-subhead text-clear">@{{ D.key }}</span>
		</div>

	</md-card-content>

</md-card>