<div flex layout=column>
    <br>
    <div layout class="padding-0-10" layout-align="center center">
        <div class="md-title margin-right-20">Configuración</div>
        <span flex></span>

    </div>
    <br>

    <div class="md-padding" layout-xs="column" layout="row">
        <div flex-xs flex-gt-xs="50" layout="column">
            <md-card>
                <div id="GestionOpciones" ng-controller="OpcionesCtrl">
                    <div ng-show="listOpciones" layout layout-align="center center" class="padding-top">
                        <div class="border-bottom">
                            <div class="md-title margin-right-20">
                                Opciones
                            </div>
                            <br>
                            <div layout="row" layout-wrap>
                                <md-container>
                                    <label style="color:rgb(179, 173, 165);">Celular Técnico Amigo</label>
                                    <div ng-repeat="Op in [Opciones.CELULAR_TECNICO_AMIGO]">
                                        @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                    </div>
                                </md-container>
                                <md-container>
                                    <label style="color:rgb(179, 173, 165);">Correo Soporte</label>
                                    <div ng-repeat="Op in [Opciones.CORREO_SOPORTE]">
                                        @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                    </div>
                                </md-container>
                                <div layout="row" layout-wrap>
                                    <md-container>
                                        <div layout="row" layout-wrap>

                                            <div><label style="color:rgb(148, 143, 137);">WhatsApp Habilitado</label>
                                                &nbsp; </div>
                                            <div ng-repeat="Op in [Opciones.WHATSAPP_SOLICITUD]">
                                                @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                            </div>
                                        </div>
                                    </md-container>
                                </div>
                            </div>
                            <div layout="row" layout-wrap>
                                <md-container>
                                    <label style="color:rgb(179, 173, 165);">Línea de crédito</label>
                                    <div ng-repeat="Op in [Opciones.LINEAS_CREDITO]">
                                        @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                    </div>
                                </md-container>
                            </div>
                            <br>

                            <div layout="row" layout-wrap>
                                <md-container>
                                    <div layout="row" layout-wrap>
                                        <div><label style="color:rgb(148, 143, 137);">Cambiar Interés de Crédito:</label>
                                            &nbsp; </div>
                                        <div ng-repeat="Op in [Opciones.CREDITO_CAMBIAR_INTERES]">
                                            @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                        </div>
                                    </div>
                                </md-container>
                            </div>
                            <div layout="row" layout-wrap>
                                <md-container>
                                    <div layout="row" layout-wrap>
                                        <div><label style="color:rgb(148, 143, 137);">Cambiar fecha de inicio de crédito:</label>
                                            &nbsp; </div>
                                        <div ng-repeat="Op in [Opciones.CREDITO_CAMBIAR_FECHA]">
                                            @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                        </div>
                                    </div>
                                </md-container>
                            </div>
                            <div layout="row" layout-wrap>
                                <md-container>

                                    <label style="color:rgb(148, 143, 137);">Interés por defecto (EA):</label>
                                    <div ng-repeat="Op in [Opciones.CREDITO_INTERES]">
                                        @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                    </div>

                                </md-container>
                            </div>
                            <div layout="row" layout-wrap>
                                <md-container>

                                    <label style="color:rgb(179, 173, 165);">Interés de mora menor a 30
                                        días:</label>
                                    <div ng-repeat="Op in [Opciones.CREDITO_MORA_MENOS_30]">
                                        @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                    </div>

                                </md-container>
                            </div>
                            <div layout="row" layout-wrap>
                                <md-container>

                                    <label style="color:rgb(179, 173, 165);">Interés de mora entre 31 a 60
                                        días:</label>
                                    <div ng-repeat="Op in [Opciones.CREDITO_MORA_31_60]">
                                        @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                    </div>

                                </md-container>
                            </div>
                            <div layout="row" layout-wrap>
                                <md-container>

                                    <label style="color:rgb(179, 173, 165);">Interés de mora entre 62 a 90
                                        días:</label>
                                    <div ng-repeat="Op in [Opciones.CREDITO_MORA_61_90]">
                                        @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                    </div>

                                </md-container>
                            </div>
                            <div layout="row" layout-wrap>
                                <md-container>

                                    <label style="color:rgb(179, 173, 165);">Interés de mora entre 91 a 120
                                        días:</label>
                                    <div ng-repeat="Op in [Opciones.CREDITO_MORA_91_120]">
                                        @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                    </div>

                                </md-container>
                            </div>
                            <div layout="row" layout-wrap>
                                <md-container>

                                    <label style="color:rgb(179, 173, 165);">Interés de mora más de 120
                                        días:</label>
                                    <div ng-repeat="Op in [Opciones.CREDITO_MORA_MAS_120]">
                                        @include('AdministracionGeneral.Configuracion_OpcionEditor')
                                    </div>

                                </md-container>
                            </div>
                            <div>
                                <md-button class="md-raised md-primary" aria-label="Nuevo"
                                    ng-click="actualizarOpciones()">
                                    Actualizar
                                </md-button>

                            </div>
                        </div>
                    </div>
                </div>
            </md-card>
        </div>
        <!--INICIO DEV ANGELICA-->

        <div flex-xs flex-gt-xs="50" layout="column">
            <md-card>
                <div id="GestionConfiguracion" ng-controller="ConfiguracionCtrl">
                    <div layout layout-align="center center" class="padding-top">
                        <md-table-container class="border-bottom">

                            <div class="md-title margin-right-20">
                                Listas
                            </div>
                            <table md-table>
                                <thead md-head>
                                    <tr md-row>
                                        <th md-column></th>
                                        <th md-column>id</th>
                                        <th md-column>Lista</th>
                                        <th md-column>Autoincremental</th>
                                    </tr>
                                </thead>
                                <tbody md-body>
                                    <tr md-row ng-repeat="C in ListaCRUD.rows">
                                        <td md-cell>
                                            <md-button class="md-icon-button" ng-click="editarLista(C)">
                                                <md-icon md-font-icon="fa-edit"></md-icon>
                                            </md-button>
                                            <md-button class="md-icon-button md-warn" ng-click="eliminarLista(C)">
                                                <md-icon md-font-icon="fa-trash"></md-icon>
                                            </md-button>
                                        </td>
                                        <td md-cell>@{{ C . id }}</td>
                                        <td md-cell>@{{ C . lista }}</td>
                                        <td md-cell>@{{ C . autoincremental }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="no-margin">
                                <md-button class="md-raised md-primary" aria-label="Nuevo" ng-click="nuevaLista()">
                                    <md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon>Nueva
                                </md-button>
                            </div>
                        </md-table-container>


                    </div>

                </div>
            </md-card>
        </div>
    </div>
</div>


<style type="text/css">


</style>
