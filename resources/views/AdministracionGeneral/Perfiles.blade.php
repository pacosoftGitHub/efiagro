<div id="AdministracionPerfiles" ng-controller="PerfilesCtrl" flex layout=column >
	
	<div layout class="padding-0-10" layout-align="center center">
		<div class="md-title">Perfiles</div>
		<span flex></span>
	</div>

	<md-card layout flex class="no-margin-top">
		<div layout=column class="padding-0-10">
			<md-button class="md-title" ng-repeat="P in PerfilesCRUD.rows" ng-click="abrirPerfil( P )">
				@{{ P.perfil }}
			</md-button>
		</div>
		<div flex class="padding-0-10 bg-light-grey overflow-y" >
			<div flex class="md-title text-center" >@{{ perfilSel.perfil }}</div>
			<table md-table id="tablaSecciones" class="border-bottom">
				<thead md-head>
				<tr md-row>
					<th md-column>Seccion</th>
					<th md-column>Subseccion</th>
					<th md-column>Nivel</th>
				</tr>
				</thead>
				<tbody md-body>
				<tr md-row ng-repeat="S in secciones">
					<td md-cell>@{{ S.seccion }}</td>
					<td md-cell>@{{ S.texto == NULL ? S.subseccion : S.texto }}</td>
					<td md-cell>
						<md-select ng-model=" S.nivel " aria-label="nivel">
							<md-option ng-repeat="NS in nivelesSeguridad" ng-value="@{{ NS.nivel }}"> <md-icon md-font-icon="@{{ NS.icono  }}"></md-icon> @{{ NS.etiqueta  }}</md-option>
						</md-select>
					</td>
				</tr>
				</tbody>
			</table>
			<md-button class="text-green-bold" ng-click="guardarPermisos()" >
				<md-icon md-font-icon="fa-hdd"></md-icon> Guardar
			</md-button>
		</div>
	</md-card>
</div>
