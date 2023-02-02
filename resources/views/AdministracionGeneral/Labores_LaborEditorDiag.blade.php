<md-dialog class="w100p mxw550" layout=column>

    <div layout class="" layout-align="center center">
        <div class="text-clear padding-left" flex> Edición de Labores </div>
        <md-button ng-click="Cancel()" class="md-icon-button no-margin">
			<md-icon md-font-icon="fa-times"></md-icon>
		</md-button>
    </div>

    <div flex layout=column class="overflow-y" >
        <div layout class="padding-0-10">
			<md-input-container  md-no-float flex>
                <label>Labor</label>
				<input type="text" ng-model="Labor.labor" placeholder="Titulo">
			</md-input-container>
		</div>
       
        <div class="padding">   
            <md-input-container  >
                <label>Frecuencia</label> 
                <input class="inputEditLabor" type="text" ng-model="Labor.frecuencia">
            </md-input-container>
            <md-input-container >
                <label>Semana de inicio</label> 
                <input class="inputEditLabor" type="text" ng-model="Labor.inicio">
               </md-input-container>
               <md-input-container > 
                <label>Margen</label> 
                <input class="inputEditLabor" type="text" ng-model="Labor.margen">
            </md-input-container>


            <md-input-container >
                <label>Zonas: @{{Labor.zona_id}}</label>
                <mat-form-field appearance="fill">
                <md-select ng-model="Labor.zona_id">
                <md-option ng-repeat="za in zonas" ng-value="za.id">
                    @{{za.descripcion}}
                </md-option>
                </mat-select>
                </mat-form-field>
            </md-input-container>
           
            <md-input-container >
                <label>Lineas productivas: @{{Labor.linea_productiva_id}}</label>
                <mat-form-field appearance="fill">
                <md-select ng-model="Labor.linea_productiva_id">
                <md-option ng-repeat="lp in lineas_productivas" ng-value="lp.id">
                    @{{lp.nombre}}
                </md-option>
                </mat-select>
                </mat-form-field>
            </md-input-container>
        
        </div>
    </div>
            
   
            <div>
                <md-button class="md-raised md-primary" ng-click="guardarLabor(Labor)">
                    <md-icon md-font-icon="fa-save"></md-icon>Guardar
                </md-button>
           
            </div>
</md-dialog>


    <style type="text/css">
        .inputEditLabor{
            border: 0;
          
        }

    </style>
