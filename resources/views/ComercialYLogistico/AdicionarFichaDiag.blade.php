<md-dialog aria-label="ADICIÓN DE FICHA TÉCNICA COMERCIAL">
  <form ng-cloak>
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>ADICIÓN DE FICHA TÉCNICA COMERCIAL</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="cancel()">
        <md-icon md-font-icon="fa-times fa-lg fa-fw"></md-icon>
        </md-button>
      </div>
    </md-toolbar>

    <md-dialog-content>
      <div class="md-dialog-content">
      <form name="userForm">

      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-xs>
            <label>Producto</label>
            <md-select ng-model="user.producto">
              <md-option value="CAFE">CAFE</md-option>
              <md-option value="PLATANO">PLATANO</md-option>
              <md-option value="MORA">MORA</md-option>
            </md-select>
        </md-input-container>
        <div flex="10" hide-xs hide-sm>
          <!-- Espaciador //-->
        </div>
        <md-input-container class="md-block" flex-gt-sm>
            <label>Calidad</label>
            <md-select ng-model="user.calidad">
              <md-option value="PRIMERAS">PRIMERAS</md-option>
              <md-option value="SEGUNDAS">SEGUNDAS</md-option>
            </md-select>
        </md-input-container>
      </div>

      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
            <label>Presentación</label>
            <md-select ng-model="user.presentacion">
              <md-option value="KILOGRAMOS">KILOGRAMOS</md-option>
              <md-option value="TONELADAS">TONELADAS</md-option>
              <md-option value="TIMBOS">TIMBOS</md-option>
              <md-option value="CANASTILLAS">CANASTILLAS</md-option>
            </md-select>
        </md-input-container>
        <div flex="10" hide-xs hide-sm>
          <!-- Espaciador //-->
        </div>
        <md-input-container class="md-block" flex-gt-sm>
            <label>Volumen</label>
            <input ng-model="user.volumen">
        </md-input-container>
        <div flex="10" hide-xs hide-sm>
          <!-- Espaciador //-->
        </div>
        <md-input-container class="md-block" flex-gt-sm>
            <label>Frecuencia</label>
            <input ng-model="user.frecuencia">
        </md-input-container>
      </div>

      <div layout-gt-xs="row">
        <md-input-container class="md-block" flex-gt-sm>
            <label>Precio</label>
            <input ng-model="user.precio">
        </md-input-container>
        <div flex="10" hide-xs hide-sm>
          <!-- Espaciador //-->
        </div>
        <div>Valor:<br/>@{{user.precio | currency}}</div>
      </div>

      <md-input-container class="md-block" flex-gt-sm>
          <label>Empaque o Embalaje</label>
          <input ng-model="user.empaque">
      </md-input-container>

      <md-input-container class="md-block">
        <label>Condiciones de Entrega</label>
        <textarea ng-model="user.condiciones_entrega" md-maxlength="255" rows="5" md-select-on-focus></textarea>
      </md-input-container>

      <md-input-container class="md-block">
        <label>Otras Condiciones</label>
        <textarea ng-model="user.otras_condiciones" md-maxlength="255" rows="5" md-select-on-focus></textarea>
      </md-input-container>
      </form>
      </div>
    </md-dialog-content>

    <md-dialog-actions layout="row">
      <md-button ng-click="cancel()">
       Cancelar
      </md-button>
      <md-button ng-click="answer('useful')">
        Guardar
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>