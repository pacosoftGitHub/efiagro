<md-dialog id="Estadisticas__Estadisticas" flex="90" aria-label="rep" class="bg-light-grey">
	<md-dialog-content >
		<div id="Estadisticas__Sections" class="onDialog">
			<div class="Section container " ng-repeat="(k,S) in RepSel.sections" flex="100" flex-gt-sm="@{{S.Width}}">
				<md-progress-circular class="md-accent" md-diameter="80" ng-if="!S.Loaded" md-mode="indeterminate"></md-progress-circular>
				<ng-include src="S.L.Template" ng-if="S.Loaded" id="Estadisticas_Section_@{{ S.id }}"></ng-include>
			</div>
		</div>
	</md-dialog-content>
</md-dialog>