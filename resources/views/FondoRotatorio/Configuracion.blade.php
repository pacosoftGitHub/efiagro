<div id="Creditos" flex ng-controller="FondoRotatorio_ConfiguracionCtrl" layout>

<md-card>
    <md-card-title>
        <md-card-title-text>
        <span class="md-headline">PORCENTAJES DEL SISTEMA</span>
        <span class="md-subhead">Fondo Rotatorio</span>
        </md-card-title-text>
    </md-card-title>
    <md-content layout-padding>
        <div>
        <form name="userForm">

            <div layout-gt-sm="row">
                <md-input-container class="md-block" flex-gt-sm>
                    <label>INTERES</label>
                    <input name="interes" ng-model="intereses.interes" placeholder=""
                        required>
                </md-input-container>
                <md-input-container class="md-block" flex-gt-sm>
                    <label>MORA 31 - 60 días</label>
                    <input name="interes3160" ng-model="intereses.interes3160" placeholder=""
                        required>
                </md-input-container>
            </div>
            <div layout-gt-sm="row">
                <md-input-container class="md-block" flex-gt-sm>
                    <label>MORA 61 - 90 días</label>
                    <input name="interes6190" ng-model="intereses.interes6190" placeholder=""
                        required>
                </md-input-container>
                <md-input-container class="md-block" flex-gt-sm>
                    <label>MORA 91 - 120 días</label>
                    <input name="interes91120" ng-model="intereses.interes91120" placeholder=""
                        required>
                </md-input-container>
            </div>
            <div layout-gt-sm="row">
                <md-input-container class="md-block" flex-gt-sm>
                    <label>MORA +120 días</label>
                    <input name="interesmas120" ng-model="intereses.interesmas120" placeholder=""
                        required>
                </md-input-container>
                <md-input-container class="md-block" flex-gt-sm>
                    <label>MORA - 30 días</label>
                    <input name="interesmenos30" ng-model="intereses.interesmenos30" placeholder=""
                        required>
                </md-input-container>
            </div>
            <div layout="row" layout-align="end center">
                <md-button class="md-raised" ng-click="actualizar()">ACTUALIZAR</md-button>
            </div>

        </form>
        </div>
    </md-content>
</md-card>
</div>
