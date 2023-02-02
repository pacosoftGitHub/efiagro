{{-- <md-dialog class="vh95 w100p mxw550" layout=column>
	
	<div layout class="" layout-align="center center">
		<div class="text-clear padding-left" flex>Edición de Articulo</div>
		<md-button ng-click="Cancel()" class="md-icon-button no-margin">
			<md-icon md-font-icon="fa-times"></md-icon>
		</md-button>
	</div>

	<div layout=column flex class="overflow-y">
		<div layout class="padding-0-10">

			<md-input-container class="no-margin md-title" md-no-float flex>
				<input type="text" ng-model="Articulo.titulo" placeholder="Titulo">
			</md-input-container>
		</div>

		<div flex layout=column>
			
			<div ng-repeat="S in SeccionesCRUD.rows" class="padding" layout ng-class="{ 'bg-yellow': S.changed }">
				
				<div>
					
					<md-menu>
						<md-button ng-click="$mdMenu.open($event)" class="md-icon-button no-margin" aria-label="Menu">
							<md-icon md-svg-icon="md-more-v"></md-icon>
						</md-button>
						<md-menu-content>
							<md-menu-item><md-button class="md-warn" ng-click="eliminarSeccion(S)">Eliminar Seccion</md-button></md-menu-item>
						</md-menu-content>
					</md-menu>

				</div>

				<div flex layout=column>
					
					<md-input-container class="no-margin" ng-if="S.tipo == 'Parrafo'" md-no-float>
			          <textarea ng-model="S.contenido" rows="5" placeholder="Contenido" ng-change="S.changed = true"></textarea>
			        </md-input-container>

			        <div ng-if="S.tipo == 'Imagen'" layout=column>
			        	
			        	<img ng-src=" @{{ S.ruta }} ">

			        </div>

			        <div ng-if="S.tipo == 'Tabla'" layout=column>
			        	
			        	<table>

			        		<thead>
			        			<th ng-repeat="C in S.contenido[0]">@{{ C }}</th>
			        			<th>+</th>
			        		</thead>

			        		<tbody>
			        			<tr ng-repeat="R in S.contenido" ng-show="!$first">
			        				<td ng-repeat="(kC,C) in S.contenido[0]">@{{ R[kC] }}</td>
			        			</tr>
			        		</tbody>

			        	</table>


			        </div>

				</div>



			</div>


			<div layout layout-align="center center">
				<md-button ng-repeat="(kT, T) in TiposSeccion" class="md-raised md-icon-button" 
					ng-click="crearSeccion(kT)" >
					<md-icon md-font-icon="@{{ T.Icono }} fa-lg fa-fw"></md-icon>
					<md-tooltip md-direction="bottom">Agregar @{{ T.Nombre }}</md-tooltip>
				</md-button>
			</div>

			<div class="h100">.</div>

		</div>
	</div>



	<div layout class="border-top">
		<span flex></span>
		<md-button class="md-raised md-primary" ng-click="guardarArticulo()">
			<md-icon md-font-icon="fa-save"></md-icon>Guardar
		</md-button>
	</div>

</md-dialog> --}}