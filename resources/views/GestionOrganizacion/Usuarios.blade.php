<div id="GestionUsuarios" flex layout=column ng-controller="UsuariosOperadorCtrl">
		<div layout=row class="padding-10">
			<md-card flex layout=row class="no-margin-top" style="width: 50%;">
				<div class="padding-20 w70p" layout=column>
					<label>Búsqueda de Usuarios</label>
					<md-input-container class="no-margin md-icon-float" md-no-float>
						<md-icon md-font-icon="fa-search fa-fw"></md-icon>
						<input type="text" ng-model="filterUsuarios" placeholder="Buscar...">
					</md-input-container>
				</div>
				<div class="padding-20 w30p" layout=column>
					<md-checkbox ng-model="estadoActivo" ng-value-true=1 ng-value-true=0 aria-label="Activo">
						Activos
					</md-checkbox>
				</div>
				<div class="padding-20 w30p" layout=column>
					<md-checkbox ng-model="estadoInactivo" ng-value-true=1 ng-value-true=0 aria-label="Activo">
						Inactivos
					</md-checkbox>
				</div>
			</md-card>
			<md-card layout=column class="no-margin-top" style="width: 50%;">
				<div class="padding-20" layout=column>
				<md-button class="md-accent md-raised md-hue-2" href="/usuarios/listado/@{{ Usuario.organizacion_id }}" target="listado">
					DESCARGAR BASE SOCIAL <md-icon md-font-icon="fa-file-excel fa-fw fa-lg"></md-icon>
				</md-button>
				</div>
			</md-card>
		</div>
	<div layout class="padding-0-10" layout-align="center center">		
		<span flex></span>
		<!--<md-button class="md-raised md-primary" aria-label="Nuevo" ng-click="nuevoUsuario()">
			<md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon> Agregar
		</md-button>//-->
	</div>
	
	<md-card flex class="no-margin-top">
		<md-table-container class="border-bottom">
			<table md-table>
				<thead md-head>
				<tr md-row>
					<th md-column></th>
					<th md-column></th>
					<th md-column></th>
					<th md-column>Nombres</th>
					<th md-column>Apellidos</th>
					<th md-column>Cédula</th>
					<th md-column>Edad</th>
					<th md-column>Género</th>
					<th md-column>Etnía</th>
					<th md-column>Departamento</th>
					<th md-column>Municipio</th>
					<th md-column>Vereda</th>
					<th md-column>Finca</th>
					<th md-column>Correo</th>
				</tr>
				</thead>
				<tbody md-body>
				<tr md-row ng-repeat="U in UsuariosCRUD.rows | filter:filterUsuarios | filter:filtrarActivo | filter:filtrarInactivo">
					<td md-cell style="padding:0 !important;color: #fff;">
						<div ng-class="U.asociado_activo == 1 ? 'activo' : (U.asociado_activo == 2 ? 'inactivo' : 'suspension')">@{{$index + 1}}</div>
					</td>
					<td md-cell style="padding-right:0; !important"><md-button class="md-icon-button" ng-click="editarUsuario(U)"  style="padding:5px;">
						<md-icon md-font-icon="fa-edit"></md-icon>
					</md-button></td>
					<td md-cell style="padding-right:0;"><md-button class="md-icon-button" ng-click="asignarClave(U)">
						<md-icon md-font-icon="fa-key"></md-icon>
					</md-button></td>
					<td md-cell>@{{ U.nombres }}</td>
					<td md-cell>@{{ U.apellidos }}</td>
					<td md-cell>@{{ U.documento }}</td>
					<td md-cell>@{{ U.edad }}</td>
					<td md-cell>@{{ U.sexo }}</td>
					<td md-cell>@{{ U.etnia }}</td>
					<td md-cell>@{{ DepartamentosTabla[U.departamento] }}</td>
					<td md-cell>@{{ MunicipiosTabla[U.municipio] }}</td>
					<td md-cell>@{{ U.vereda }}</td>
					<td md-cell>@{{ U.finca }}</td>
					<td md-cell>@{{ U.correo }}</td>
				</tr>
				</tbody>
			</table>
		</md-table-container>
	</md-card>

</div>

<style>
	.activo{
		width: 100%;
		margin: 2px;
		padding: 2px;
		text-align: center;
		border-radius: 5px;
		background-color: #7fad86;
	}
	.inactivo{
		width: 100%;
		margin: 2px;
		padding: 2px;
		text-align: center;
		color: #000;
		border-radius: 5px;
		background-color: #f9fac0;
	}
	.suspension{
		width: 100%;
		margin: 2px;
		padding: 2px;
		text-align: center;
		border-radius: 5px;
		background-color: #ad4e4b;
	}
</style>