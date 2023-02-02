<div id="GestionLabores" ng-controller="LaboresCtrl" flex layout=column>
	
	<div layout class="padding-0-10" layout-align="center center">
		<div class="md-title">Gestion de Labores</div>
		<span flex></span>
	
		<div>
			<md-input-container >
                <md-select ng-model="zona_select" ng-change="getLabores()">
                	<md-option ng-repeat="za in zonas" ng-value="za.id">@{{za.descripcion}}</md-option>
                </mat-select>
            </md-input-container>
           
            <md-input-container >
                
                <md-select ng-model="linea_lp_select" ng-change="getLabores()" >
                	<md-option ng-repeat="lp in lineas_productivas" ng-value="lp.id">@{{lp.nombre}}</md-option>
                </mat-select>
            </md-input-container>

		</div>
		<span flex></span>

		<md-input-container class="no-margin md-icon-float" md-no-float>
			<md-icon md-font-icon="fa-search fa-fw"></md-icon>
			<input type="text" ng-model="filterLabores" placeholder="Buscar...">
		</md-input-container>
		
		<span flex></span>
		<md-button class="md-raised md-primary" aria-label="Nueva" ng-click="nuevaLabor()">
			<md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon>Agregar Labor
		</md-button>
	</div>
	<md-card flex class="no-margin-top">
	<md-table-container class="border-bottom">
	  <table md-table>
	    <thead md-head>
	      <tr md-row>
			<th md-column>Acción</th>
			{{-- <th md-column>ID</th> --}}
	        <th md-column>Labor</th>
			<th md-column>Zona</th>
			<th md-column>Linea Productiva</th>
	        <th md-column>Frecuencia</th>
	        <th md-column>Semana de Inicio</th>
	        <th md-column>Margen</th>
			
	      </tr>
	    </thead>
	    <tbody md-body>
			<tr md-row ng-repeat="L in LaboresCRUD.rows | filter:filterLabores">
				<td md-cell>
					<md-button class="md-icon-button" ng-click="editarLabor(L)">
						<md-icon md-font-icon="fa-edit"></md-icon>
					</md-button>
					<md-button class="md-icon-button md-warn" ng-click="eliminarLabor(L)">
						<md-icon md-font-icon="fa-trash"></md-icon>
					</md-button>
				</td>
			{{-- <td md-cell>@{{ L.id }} </td> --}}
	        <td md-cell>@{{ L.labor }}</td>
			<td md-cell>@{{ L.zona.descripcion }}</td>
			<td md-cell>@{{ L.linea_productiva.nombre }} </td> 
            <td md-cell><span>CADA</span> <b>@{{ L.frecuencia }}</b> <span>SEMANAS</span></td>
            <td md-cell>  <span>SEMANA</span> <b>@{{ L.inicio }}</b></td>
            <td md-cell><b>@{{ L.margen }}</b> <span>SEMANAS</span></td>
			
	      </tr>
	    </tbody>
	  </table>
	</md-table-container>
	</md-card>

</div>
