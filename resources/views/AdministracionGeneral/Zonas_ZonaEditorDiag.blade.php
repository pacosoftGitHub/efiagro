<md-dialog class="w100p mxw550" layout=column>

    <div layout class="" layout-align="center center">
        <div class="text-clear padding-left" flex> Edición de Zonas </div>
        <md-button ng-click="Cancel()" class="md-icon-button no-margin">
			<md-icon md-font-icon="fa-times"></md-icon>
		</md-button>
    </div>

    <div flex layout=column class="overflow-y" >
        <div layout class="padding-0-10">
			<md-input-container >
                <label>Zona</label>
				<input type="text" ng-model="Zona.descripcion" placeholder="Titulo">
			</md-input-container>

            <md-input-container >
                <label>Lineas productivas: @{{Zona.linea_productiva_id}}</label>
                <mat-form-field appearance="fill">
                    <md-select ng-model="Zona.linea_productiva_id">
                        <md-option ng-repeat="lp in lineas_productivas" ng-value="lp.id">
                            @{{lp.nombre}}
                        </md-option>
                    </mat-select>
                </mat-form-field>
            </md-input-container>
		</div>

        <div class="padding">
            
            
        
            <md-input-container  >
                <label>	Temperatura Min</label> 
                <input class="inputEdit" type="text" ng-model="Zona.temperatura_min">
            </md-input-container>
            <md-input-container  >
                <label>Temperatura Max</label> 
                <input class="inputEdit" type="text" ng-model="Zona.temperatura_max">
            </md-input-container>
            <md-input-container  >
                <label>Humedad Relativa Min</label> 
                <input class="inputEdit" type="text" ng-model="Zona.humedad_relativa_min">
            </md-input-container>
            <md-input-container  >
                <label>Humedad Relativa Max</label> 
                <input class="inputEdit" type="text" ng-model="Zona.humedad_relativa_max">
            </md-input-container>
            <md-input-container  >
                <label>Precipitación Min</label> 
                <input class="inputEdit" type="text" ng-model="Zona.precipitacion_min">
            </md-input-container>
            <md-input-container  >
                <label>Precipitación Max</label> 
                <input class="inputEdit" type="text" ng-model="Zona.precipitacion_max">
            </md-input-container>
            <md-input-container  >
                <label>	Altimetria Min</label> 
                <input class="inputEdit" type="text" ng-model="Zona.altimetria_min">
            </md-input-container>
            <md-input-container  >
                <label>	Altimetria Max</label> 
                <input class="inputEdit" type="text" ng-model="Zona.altimetria_max">
            </md-input-container>
            <md-input-container  >
                <label>Brillo Solar Min</label> 
                <input class="inputEdit" type="text" ng-model="Zona.brillo_solar_min">
            </md-input-container>
            <md-input-container  >
                <label>Brillo Solar Max</label> 
                <input class="inputEdit" type="text" ng-model="Zona.brillo_solar_max">
            </md-input-container>
            <md-input-container  >
                <label>Pendiente Min</label> 
                <input class="inputEdit" type="text" ng-model="Zona.pendiente_min">
            </md-input-container>
            <md-input-container  >
                <label>Pendiente Max</label> 
                <input class="inputEdit" type="text" ng-model="Zona.pendiente_max">
            </md-input-container>
        </div>
    </div>
            <div>
                <md-button class="md-raised md-primary" ng-click="guardarZona(Zona)">
                    <md-icon md-font-icon="fa-save"></md-icon>Guardar
                </md-button>
            </div>
</md-dialog>


    <style type="text/css">
        .inputEdit{
            border: 0;
          
        }

    </style>
