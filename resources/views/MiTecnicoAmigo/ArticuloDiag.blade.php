<md-dialog class="vh95 w100p mxw550" layout=column>

	<div layout>
		<div flex class="md-title padding-top padding-left">
			@{{ Articulo.titulo }}		
		</div>
		<md-button class="md-icon-button no-margin" aria-label="salir" ng-click="Salir()">
			<md-icon md-font-icon="fa-times fa-lg fa-fw"></md-icon>
		</md-button>
	</div>
	
	<div flex layout=column class="padding-10-20 overflow-y">
	
		<div ng-repeat="S in Articulo.secciones">
			
			<div ng-if="S.tipo == 'Parrafo'" class="margin-bottom text-justify">@{{ S.contenido }}</div>
			<div ng-if="S.tipo == 'Imagen'" class="margin-bottom" layout=column>
				<img ng-src=" @{{ S.ruta }} ">
			</div>
			<div ng-if="S.tipo == 'Tabla'" class="margin-bottom" layout=column>
				<table>
	        		<thead>
	        			<th ng-repeat="C in S.contenido[0]">@{{ C }}</th>
	        		</thead>

	        		<tbody>
	        			<tr ng-repeat="R in S.contenido" ng-show="!$first">
	        				<td ng-repeat="(kC,C) in S.contenido[0]">@{{ R[kC] }}</td>
	        			</tr>
	        		</tbody>

	        	</table>
			</div>

		</div>	

		<div class="h120">&nbsp;</div>	

	</div>

</md-dialog>