<div id="GestionCultivos" ng-controller="CultivosCtrl" flex layout=column>
	
	<div layout class="padding-0-10" layout-align="center center">
		<div class="md-title">Gestion Cultivos</div>
		<span flex></span>
		<div>
			<md-input-container>
                <md-select ng-model="zona_select" ng-change="getCultivos()">
                    <md-option  ng-repeat="za in zonas" ng-value="za.id">@{{za.descripcion}}</md-option>
                </mat-select>
			</md-input-container>
           
		</div>
	
		<span flex></span>

		<md-input-container class="no-margin md-icon-float" md-no-float>
			<md-icon md-font-icon="fa-search fa-fw"></md-icon>
			<input type="text" ng-model="filterCultivos" placeholder="Buscar...">
		</md-input-container>
		
		<span flex></span>
		<md-button class="md-raised md-primary" ng-click="nuevoCultivo()">
			<md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon>Agregar Cultivo
		</md-button>
	</div>
	<md-card flex class="no-margin-top">
	<md-table-container class="border-bottom">
	  <table md-table>
	    <thead md-head>
	      <tr md-row>
			<th md-column>Acción</th>
			{{-- <th md-column>ID</th> --}}
	        <th md-column>Fechas</th>
			<th md-column>Zona</th>
			<th md-column>Producción</th>
	        <th md-column>Producción Estimada</th>
	        <th md-column>Eventos</th>
	        <th md-column>Creditos Colocados</th>
            <th md-column>Cartera Vencida</th>
			
	      </tr>
	    </thead>
	    <tbody md-body>
			<tr md-row ng-repeat="C in CultivosCRUD.rows | filter:filterCultivos">
				<td md-cell>
					<md-button class="md-icon-button" ng-click="editarCultivo(C)">
						<md-icon md-font-icon="fa-edit"></md-icon>
					</md-button>
					<md-button class="md-icon-button md-warn" ng-click="eliminarCultivo(C)">
						<md-icon md-font-icon="fa-trash"></md-icon>
					</md-button>
				</td>
				{{-- <td md-cell>@{{ L.id }} </td> --}}
				<td md-cell>@{{ C.fechas | date:'yyyy-MM-dd'}}</td>
				<td md-cell>@{{ C.zona.descripcion }}</td>
				<td md-cell>@{{ C.produccion }}<span>kg</span></td> 
				<td md-cell>@{{ C.produccion_estimada }}<span>kg</span></td>
				<td md-cell>@{{ C.eventos }}</td>
				<td md-cell>@{{ C.creditos_colocados }}</td>
				<td md-cell>@{{ C.cartera_vencida }}</td>
	      </tr>
	    </tbody>
	  </table>
	</md-table-container>
	</md-card>

</div>
