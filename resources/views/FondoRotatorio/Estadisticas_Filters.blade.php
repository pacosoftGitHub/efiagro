<div class="Filter margin-right-20 h50" ng-repeat="F in RepSel.filters" layout layout-align="center center">
	<div class="Desc text-clear margin-right">@{{ F.Desc }}:</div>

	<md-datepicker ng-if="F.Type == 'Date'" 
		ng-model="F.Value" 
		md-placeholder="@{{ F.Desc }}"
		md-hide-icons="calendar"></md-datepicker>

	<md-select ng-model="F.Value" placeholder="@{{ F.Desc }}" ng-if="F.Type == 'Select'" ng-change="Load()">
		<md-option ng-repeat="Op in F.Pattern" ng-value="Op">@{{Op}}</md-option>
	</md-select>

	<md-input-container md-no-float layout ng-if="F.Type == 'Number'">
		<input ng-model="F.Value" placeholder="@{{ F.Desc }}"  type="number" class="w70" enter-stroke="Load()">
	</md-input-container>

</div>