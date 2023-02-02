<md-dialog class="vh95 w100p mxw550" >
	<div layout class="" layout-align="center center">
		<div class="text-clear padding-left" flex>Organizaciones para el usuario @{{ DatosUsuario.nombre }} </div>
		<md-button ng-click="Cancel()" class="md-icon-button no-margin">
			<md-icon md-font-icon="fa-times"></md-icon>
		</md-button>
	</div>
	<div layout=column>
		<md-input-container>
			<label>Agregar las organizaciones disponibles</label>
			<md-select ng-show="Noasignada" ng-model="organizacionseleccionada" ng-change="agregarOrganizacion(organizacionseleccionada)"
				class="margin" aria-label="Organizaciones_del_usuario" >
				<md-option ng-value="no.id" ng-repeat="no in Noasignada">@{{ no.nombre }}</md-option>
			</md-select>
		</md-input-container>
		<div flex-gt-sm="50" flex>
			<md-toolbar layout="row" class="md-hue-3">
				<div class="md-toolbar-tools">
					<span>Organizaciones asignadas a @{{ DatosUsuario.nombre }}</span>
				</div>
			</md-toolbar>
			<md-content>
				<md-list flex>
					<md-list-item class="md-3-line" ng-repeat="O in Organizaciones" >
						<div class="md-list-item-text" layout="column">
							<h3>@{{ O.nombre }}</h3>
							<p>Dir: @{{ O.nit }} | NIT @{{ O.direccion }}</p>
						</div>
						<md-divider ></md-divider>
					</md-list-item>
				</md-list>
			</md-content>
		</div>
		
	</div>
</md-dialog>
