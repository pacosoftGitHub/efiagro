<div id="LineasProductivas" flex layout=column ng-controller="LineasProductivasCtrl">
    <div class="padding-0-10" layout layout-align="center">
        <div class="md-title">Gestión de Lineas productivas</div>
        <span flex></span>
        <md-button class="md-raised md-primary" aria-label="Nuevo" ng-click="nuevo()">
            <md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon> Agregar
        </md-button>
    </div>

    <div class="padding-0-10" layout flex layout-align="center" >
        <div layout=column class="padding-10-10">
            <md-card layout=column class="no-margin-top mxw200">
            <div class="padding-20" layout=column>
                <label>Filtros de búsqueda</label>
                <md-input-container>
                    <label>Descripción</label>
                    <input ng-change="buscador()" type="text" ng-model="filtroDescripcion" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()"" aria-label="descripcion">
                </md-input-container>
                <md-input-container>
                    <label>Palabas claves</label>
                    <input ng-change="buscador()" type="text" ng-model="filtroPalabras" placeholder="" ng-model-options="{ debounce: 1000 }" autocomplete="off" enter-stroke="buscador()"" aria-label="Palabras clave">
                </md-input-container>
                </div>
            </md-card>
        </div>

        <md-card flex class="no-margin-top" >
            <md-table-container>
                <table md-table >
                    <thead md-head >
                    <tr md-row>
                        <th md-column>Imagen</th>
                        <th md-column>Cambiar</th>
                        <th md-column>Descripción</th>
                        <th md-column>Palabas claves</th>
                        <th md-column>Creado</th>
                        <th md-column>Actualizado</th>
                    </tr>
                    </thead>
                    <tbody md-body >
                        <tr md-row ng-repeat="LP in LineasProductivasCRUD.rows | filter:{nombre:filtroDescripcion, palabras_clave:filtroPalabras}">
                            <td md-cell>
                                <img ng-src="files/lineasproductivas_media/@{{ LP.id }}.jpg" alt="" width="30">
                            </td>
                            <td md-cell>
                                <md-button class="md-icon-button pointer" >
                                    <md-icon md-font-icon="fa-image" ng-click="cargarImagen(LP)"></md-icon>
                                </md-button>
                            </td>
                            <td md-cell>
                            <md-input-container>
                                <input ng-change="guardarLP(LP)" type="text" ng-model="LP.nombre" aria-label="descripcion"></md-input-container>
                            </td>
                            <td md-cell>
                                <md-chips ng-model="LP.palabras_clave" ng-change="guardarLP(LP)">
                                </md-chips>
                            </td>
                            <td md-cell>@{{LP.created_at | date:'yyyy-MM-dd' }}</td>
                            <td md-cell>@{{LP.updated_at | date:'yyyy-MM-dd' }}</td>
                        </tr>
                    </tbody>
                </table>
            </md-table-container>
        </md-card>
    </div>
</div>