<md-dialog class="vh95 w100p mxw550" layout=column>
	
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
			<div ng-repeat="S in SeccionesCRUD.rows | orderBy : 'indice'" class="padding" layout ng-class="{ 'bg-yellow': S.changed }">
				<div>
					<md-menu>
						<md-button ng-click="$mdMenu.open($event)" class="md-icon-button no-margin" aria-label="Menu">
							<md-icon md-svg-icon="md-more-v"></md-icon>
						</md-button>
						<md-menu-content>
							<md-menu-item ng-show=" !$first ">
								<md-button class="md-warn" ng-click="moverSeccion(S, -1)">
									<md-icon md-svg-icon="md-north"></md-icon>
									Subir sección </md-button></md-menu-item>
							<md-menu-item>
								<md-button class="md-warn" ng-click="eliminarSeccion(S)">
									<md-icon md-svg-icon="md-delete"></md-icon>
									Eliminar sección </md-button></md-menu-item>
							<md-menu-item ng-show=" !$last ">
								<md-button class="md-warn" ng-click="moverSeccion(S, 1)">
									<md-icon md-svg-icon="md-south"></md-icon>
									Bajar sección </md-button></md-menu-item>
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
			        	<table border=1 style="border-collapse: collapse;">
			        		<thead>
			        			<th ng-repeat="(kC,C) in S.contenido[0] track by $index">
			        				<md-input-container class="no-margin">
			        					<input type="text" ng-model="C" ng-change="S.changed = true" ng-blur="S.contenido[0][kC] = C" aria-label="t">
			        				</md-input-container>
			        				<md-menu>
			        					<md-button ng-click="$mdMenu.open($event)" class="md-icon-button" aria-label="Abrir Menu">
											<md-icon md-svg-icon="md-more-v"></md-icon>
										</md-button>
										<md-menu-content>
											<md-menu-item><md-button class="md-warn" ng-click="eliminarColumna(S, kC)">Eliminar</md-button></md-menu-item>
										</md-menu-content>
			        				</md-menu>
			        			</th>
			        			<th>
			        				<md-button class="md-icon-button" ng-click="agregarColumna(S)">
			        					<md-icon md-svg-icon="md-plus"></md-icon>
			        					<md-tooltip>Agregar Columna</md-tooltip>
			        				</md-button>
			        			</th>
			        		</thead>

			        		<tbody>
			        			<tr ng-repeat="(kR,R) in S.contenido" ng-show="!$first">
			        				<td ng-repeat="(kC,C) in S.contenido[0] track by $index">
			        					<md-input-container class="no-margin">
				        					<input type="text" ng-model="R[kC]" ng-change="S.changed = true" aria-label="t">
				        				</md-input-container>
			        				</td>
			        				<td>
			        					<md-button class="md-icon-button" ng-click="eliminarFila(S, kR)">
				        					<md-icon md-svg-icon="md-close"></md-icon>
				        					<md-tooltip>Eliminar Fila</md-tooltip>
				        				</md-button>
			        				</td>
			        			</tr>
			        		</tbody>
			        	</table>
			        	<md-button class="md-icon-button" ng-click="agregarFila(S)">
			        		<md-tooltip>Agregar Fila</md-tooltip>
        					<md-icon md-svg-icon="md-plus"></md-icon>
        				</md-button>
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

	<!--INICIO DEV ANGÉLICA - CHIPS ANGULA MATERIAL-->
	<md-chips ng-model="keyWords" readonly="readonly" md-removable="removable">
    </md-chips>
	<!--FIN DEV ANGÉLICA - CHIPS ANGULA MATERIAL-->

	<!--INICIO DEV ANGÉLICA - Lineas productivas en select-->
	<h4>Lineas productivas @{{Articulo.linea_productiva_id}} </h4>
	<mat-form-field appearance="fill">
  	<mat-label>Elige la linea productiva</mat-label>
	<md-select ng-model="Articulo.linea_productiva_id">
		<md-option ng-repeat="lp in lineas_productivas" ng-value="lp.id">
      		@{{lp.nombre}}
   		</md-option>
	</mat-select>
	</mat-form-field>
	<!--FIN DEV ANGÉLICA-->
	
	<div layout class="border-top">
		<span flex></span>
		<md-button class="md-raised md-primary" ng-click="guardarArticulo()">
			<md-icon md-font-icon="fa-save"></md-icon>Guardar
		</md-button>
	</div>

</md-dialog>