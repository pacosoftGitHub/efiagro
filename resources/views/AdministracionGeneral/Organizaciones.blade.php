<div id="GestionOrganizaciones" ng-controller="OrganizacionesCtrl" flex layout=column>

    <div layout class="padding-0-10" layout-align="center center">
        <div class="md-title">Gestion de Organizaciones</div>
        <span flex></span>
        <md-input-container class="no-margin md-icon-float" md-no-float>
            <md-icon md-font-icon="fa-search fa-fw"></md-icon>
            <input type="text" ng-model="filterOrganizaciones" placeholder="Buscar...">
        </md-input-container>

        <span flex></span>
        <!--<md-select ng-change="selectChanged()" ng-model="value">
   <md-option value="1">Algo</md-option>
   <md-option value="2">Algo 2</md-option>
   <md-option value="3">Algo 3</md-option>
  </md-select>-->
        <md-button class="md-raised md-primary" aria-label="Nuevo" ng-click="nuevaOrganizacion()">
            <md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon>Agregar Organización
        </md-button>
    </div>

    <div class="padding-0-10" layout flex layout-align="center">
        <div layout=column class="padding-10-10">
            <md-card layout=column class="no-margin-top mxw230">
                <div class="padding-20" layout=column>
                    <label>Filtros de búsqueda</label>

                    <md-input-container>
                        <label>Nombre</label>
                        <input ng-change="filterOrganizacion()" type="text" ng-model="filterNombre" placeholder=""
                            ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()"
                            aria-label="Palabras clave">
                    </md-input-container>

                    <md-input-container>
                        <label>Nit</label>
                        <input ng-change="filterOrganizacion()" type="text" ng-model="filterNit" placeholder=""
                            ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()"
                            aria-label="Palabras clave">
                    </md-input-container>
                </div>
            </md-card>
        </div>


        <md-card flex class="no-margin-top">
            <md-table-container class="border-bottom">
                <table md-table>
                    <thead md-head>
                        <tr md-row>
                            <th md-column>Acción</th>
                            <th md-column>ID</th>
                            <th md-column>Nombre</th>
                            <th md-column>Sigla</th>
                            <th md-column>NIT</th>
                            <th md-column>Linea Productiva</th>
                            {{-- <th md-column>Dirección</th> --}}
                            <th md-column>Telefono</th>
                            <th md-column>Correo</th>
                            <th md-column>Sel</th>
                        </tr>
                    </thead>
                    <tbody md-body>
                        <tr md-row ng-repeat="O in OrganizacionesCRUD.rows">
                            <td md-cell>
                                <div>
                                    <md-menu>
                                        <md-button ng-click="$mdMenu.open($event)" class="md-icon-button no-margin" aria-label="Menu">
                                            <md-icon md-svg-icon="md-more-v"></md-icon>
                                        </md-button>
                                        <md-menu-content>
                                            <md-menu-item>
                                                <md-button class="md-warn" ng-click="editarOrganizacion(O)">
                                                    <md-icon md-font-icon="fa-edit"></md-icon>
                                                Editar</md-button>
                                            </md-menu-item>
                                            <md-menu-item ng-if="O.id !== Usuario.organizacion_id">
                                                <md-button class="md-warn" ng-click="seleccionar(Usuario.id, O.id)">
                                                    <md-icon md-font-icon="fa-chart-area"></md-icon>
                                                Activar </md-button>
                                            </md-menu-item>
                                            <md-menu-item>
                                                <md-button class="md-warn" ng-click="eliminarOrganizacion(O)">
                                                    <md-icon md-font-icon="fa-trash"></md-icon>
                                                Eliminar </md-button>
                                            </md-menu-item>
                                            <md-menu-item ng-if="O.id === Usuario.organizacion_id">
                                                <md-button class="md-warn" ng-click="quitar(Usuario.id)">
                                                    <md-icon md-font-icon="fa-chart-area"></md-icon>
                                                Quitar Seleccion</md-button>
                                            </md-menu-item>
                                        </md-menu-content>
                                    </md-menu>
                                </div>
                            </td>
                            <td md-cell>@{{ O.id }}</td>
                            <td md-cell>@{{ O.nombre }}</td>
                            <td md-cell>@{{ O.sigla }}</td>
                            <td md-cell>@{{ O.nit }}</td>
                            <td md-cell>@{{ O.linea_productiva . nombre }}</td>
                            {{-- <td md-cell>@{{ O.direccion }}</td> --}}
                            <td md-cell>@{{ O.telefono }}</td>
                            <td md-cell>@{{ O.correo }}</td>
                            <td md-cell>
                                <md-icon md-font-icon="fa-edit" ng-if="Usuario.organizacion_id === O.id"></md-icon>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </md-table-container>
        </md-card>
    </div>
</div>
