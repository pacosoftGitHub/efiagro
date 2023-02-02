<div id="Usuarios" flex layout=column ng-controller="UsuariosCtrl">
    <div class="padding-0-10" layout layout-align="center">
        <div class="md-title">Gestión de Usuarios</div>
        <span flex></span>
        <md-button class="md-raised md-primary" aria-label="Nuevo" ng-click="nuevo()">
            <md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon> Agregar
        </md-button>
        <md-card>
            <input type="file" name="plantilla" id="plantilla" onchange="angular.element(this).scope().subirArchivo(event.target.files)" />
            
            <md-button class="md-raised md-primary" aria-label="Nuevo" ng-click="pruebaPost($files)">
                <md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon> Importar
            </md-button>
        </md-card>
    </div>

    <div class="padding-0-10" layout=column flex layout-align="center" >
		<div layout=column class="padding-10">
			<md-card layout=column class="no-margin-top w90p">
				<div class="padding-20" layout=column>
					<label>Filtros de búsqueda</label>
                    <md-input-container>
						<label>Nombre, Cédula, Apellido, ...</label>
						<input change="filterUsuarios()" type="text" ng-model="filterDocumento" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>
                    <!--
					<md-input-container>
						<label>Documento</label>
						<input change="filterUsuarios()" type="text" ng-model="filterDocumento" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>
                    <md-input-container>
						<label>Nombres</label>
						<input change="filterUsuarios()" type="text" ng-model="filterNombre" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>

					<md-input-container>
						<label>Apellidos</label>
						<input change="filterUsuarios()" type="text" ng-model="filterApellido" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()" aria-label="Palabras clave">
					</md-input-container>
                    //-->
				</div>
			</md-card>
		</div>

        <md-card flex class="no-margin-top" >
            <md-table-container>
                <table md-table >
                    <thead md-head >
                    <tr md-row>
                        <th md-column>Acciones</th>
                        <th md-column></th>
                        <th md-column>TD</th>
                        <th md-column>Documento</th>
                        <th md-column>Nombre</th>
                        <th md-column>Apellido</th>
                        <th md-column>Correo</th>
                        <th md-column>Celular</th>
                        <th md-column>Perfil</th>
                        <th md-column>Organización</th>
                    </tr>
                    </thead>
                    <tbody md-body >
                        <tr md-row ng-repeat="U in UsuariosCRUD.rows | filter:filterNombre | filter:filterApellido  | filter:filterDocumento">
                            <td md-cell width="20px">
                                <div>
                                    <md-menu>
                                        <md-button ng-click="$mdMenu.open($event)" class="md-icon-button no-margin" aria-label="Menu">
                                            <md-icon md-svg-icon="md-more-v"></md-icon>
                                        </md-button>
                                        <md-menu-content>
                                            <md-menu-item>
                                                <md-button class="md-warn" ng-click="editarUsuario(U)">
                                                    <md-icon md-font-icon="fa-edit"></md-icon>
                                                Editar </md-button>
                                            </md-menu-item>
                                            <md-menu-item>
                                                <md-button class="md-warn" ng-click="cambiarClave(U)">
                                                    <md-icon md-font-icon="fa-key"></md-icon>
                                                Cambio de Clave </md-button>
                                            </md-menu-item>
                                            <md-menu-item>
                                                <md-button class="md-warn" ng-click="cargarFincas(U)">
                                                    <md-icon md-font-icon="fa-chart-area"></md-icon>
                                                Fincas / Lotes </md-button>
                                            </md-menu-item>
                                            <md-menu-item>
                                                <md-button class="md-warn" ng-click="organizaciones(U)">
                                                    <md-icon md-font-icon="fa-plus"></md-icon>
                                                Organizaciones </md-button>
                                            </md-menu-item>
                                        </md-menu-content>
                                    </md-menu>
                                </div>
                            </td>
                            <td md-cell width="20px">
                                <div ng-class="U.asociado_activo == 1 ? 'activo' : (U.asociado_activo == 2 ? 'inactivo' : 'suspension')">@{{$index + 1}}</div>
                            </td>
                            <td md-cell width="20px">@{{ U.tipo_documento }}</td>
                            <td md-cell>@{{ U.documento }}</td>
                            <td md-cell>@{{ U.nombres }}</td>
                            <td md-cell>@{{ U.apellidos }}</td>
                            <td md-cell>@{{ U.correo }}</td>
                            <td md-cell>@{{ U.celular }}</td>
                            <td md-cell>@{{ U.perfil.perfil }}</td>
                            <td md-cell>@{{ U.organizaciones_usuario.nombre }}</td>
                        </tr>
                    </tbody>
                </table>
            </md-table-container>
        </md-card>
    </div>
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