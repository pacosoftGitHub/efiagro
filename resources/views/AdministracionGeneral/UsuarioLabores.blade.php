<md-dialog flex=100 class="vh100" layout=column id="modallabores">
    
    <div layout layout-align="center center" class="padding-left border-bottom bg-white">
        <div class="text-clear md-title" flex>Labores Registradas</div>
        <div class="text-clear margin-right">Año:</div>
        <md-select aria-label="anioSelected" ng-model="anioSelected" ng-change="cambiarAnio(anioSelected)" class="no-margin md-no-underline">
            <md-option ng-repeat="a in anios" ng-value="a"> @{{ a }}  </md-option>
        </md-select>
        <md-button ng-click="Cancel()" class="md-icon-button no-margin">
			<md-icon md-svg-icon="md-close"></md-icon>
		</md-button>
    </div>

    <div flex layout class="overflow-y">
        <div class="w300 bg-light-grey">
            <md-table-container class="border-bottom">
                <table md-table >
                    <thead md-head >
                        <tr md-row>
                            <th md-column style="padding: 0 0 0 10px;">Labores</th>
                            <th md-column class="no-padding w30 text-center">In</th>
                            <th md-column class="no-padding w30 text-center">Fr</th>
                            <th md-column class="no-padding w30 text-center">Ma</th>
                        </tr>
                    </thead>
                    <tbody md-body>
                        <tr md-row ng-repeat="L in InfoLabores" class="bg-light-grey">
                            <td md-cell style="padding: 0 0 0 10px;">@{{ L.labor }}</td>
                            <td md-cell class="no-padding w30">
                                <md-input-container class="no-margin no-padding w100p md-no-underline">
                                    <input type="text" ng-model="L.inicio" aria-label=i ui-number-mask=0 class="text-right" ng-change="actualizarLabor(L)">
                                </md-input-container>
                            </td>
                            <td md-cell class="no-padding w30">
                                <md-input-container class="no-margin no-padding w100p md-no-underline">
                                    <input type="text" ng-model="L.frecuencia" aria-label=i ui-number-mask=0 class="text-right" ng-change="actualizarLabor(L)">
                                </md-input-container>
                            </td>
                            <td md-cell class="no-padding w30">
                                <md-input-container class="no-margin no-padding w100p md-no-underline">
                                    <input type="text" ng-model="L.margen" aria-label=i ui-number-mask=0 class="text-right" ng-change="actualizarLabor(L)">
                                </md-input-container>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </md-table-container>

            <div layout=column class="bg-light-grey padding-0-10 border-right"> 
                
                <div layout class="margin-top">
                    <md-input-container flex>
                        <label for="">Agregar Labor</label>
                        <input type="text" ng-model="nuevaLabor" enter-stroke="agregarLabor()" placeholder="Escriba la nueva labor" />
                    </md-input-container>
                    <div><md-button class="md-primary md-raised" style="margin: 14px 0 0;" ng-click="agregarLabor()">Agregar</md-button></div>
                </div>
                
            </div>
            
        </div>
        <div flex class="">
            <md-table-container flex class="bg-white">
                <table md-table>
                    <thead md-head >
                        <tr md-row>
                            <th md-column ng-repeat="S in encabezado" style="text-align: center; padding: 3px">@{{ S.semana }}
                                <br>@{{ S.fecha_corta }}
                            </th>
                        </tr>
                    </thead>
                    <tbody md-body>
                        <tr md-row ng-repeat="L in detalle">
                            <td md-cell ng-repeat="S in L" class="@{{ S.tipo }}"></td>
                        </tr>
                    </tbody>
                </table>
            </md-table-container>
        </div>
    </div>
    
    <style>
        td.principal {
            background-color: #7BD8F9;
        }
        td.secundaria {
            background-color: #D3F2FD;
        }
        td.establecimiento {
            background-color: #BEFFBC;
        }
        td, th{
            border-top: none !important;
            border-right: 1px solid #d0d0d0;
            border-bottom:  1px solid #d0d0d0;
        }
        .datolabor{
            padding: 3px; 
            margin: 0;
            width: 10px;
        }

        .md-no-underline input{
            border-bottom: none;
        }

        .border-right{
            border-right: 1px solid #d0d0d0;
        }
    </style>

</md-dialog>