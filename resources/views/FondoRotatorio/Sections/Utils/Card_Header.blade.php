<md-card-header class="padding-but-bottom" layout> 
	<md-card-header-text layout=column>
		<span class="md-title">@{{ S.L.Titulo }}</span>
    	<span class="md-caption text-bold text-clear">@{{ S.L.Subtitulo }}</span>
	</md-card-header-text>
	<md-menu class="no-padding not-on-print">
		<md-button class="md-icon-button no-margin no-padding focus-on-hover mh30 h30 w30" aria-label="Dot" ng-click="$mdMenu.open()">
			<md-icon md-font-icon="fa-ellipsis-v" class="fa-lg"></md-icon>
		</md-button>
		<md-menu-content class="no-padding">
			<md-menu-item>
				<md-button print-this="#Estadisticas_Section_@{{ S.id }}">
					<md-icon md-font-icon="fa-print" class="fa-lg"></md-icon>Imprimir
				</md-button>
			</md-menu-item>
			<md-menu-item>
				<md-button ng-click="Download()">
					<md-icon md-font-icon="fa-download" class="fa-lg"></md-icon>Descargar Datos
				</md-button>
			</md-menu-item>
		</md-menu-content>
	</md-menu>
</md-card-header>