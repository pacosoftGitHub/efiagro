<md-dialog aria-label="ADICIÓN DE CLIENTE" style="width:500px;">
  <form ng-cloak>
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>ADICIÓN DE CLIENTE</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="cancel()">
        <md-icon md-font-icon="fa-times fa-lg fa-fw"></md-icon>
        </md-button>
      </div>
    </md-toolbar>

    <md-dialog-content>
      <div class="md-dialog-content">
      <form name="userForm">

        <md-input-container class="md-block" flex-gt-sm>
            <label>Número Documento</label>
            <input ng-model="usuario.numero_documento">
        </md-input-container>

        <md-input-container class="md-block" flex-gt-sm>
            <label>Nombre del Cliente</label>
            <input ng-model="usuario.nombre">
        </md-input-container>

        <md-input-container class="md-block" flex-gt-sm>
            <label>Ciudad</label>
            <md-select ng-model="user.ciudad">
              <md-option value="PEREIRA">PEREIRA</md-option>
              <md-option value="ARMENIA">ARMENIA</md-option>
              <md-option value="MANIZALES">MANIZALES</md-option>
            </md-select>
        </md-input-container>

        <md-input-container class="md-block" flex-gt-sm>
            <label>Dirección</label>
            <input ng-model="usuario.direccion">
        </md-input-container>

        <md-input-container class="md-block" flex-gt-sm>
            <label>Persona Contacto</label>
            <input ng-model="usuario.contacto">
        </md-input-container>

        <md-input-container class="md-block" flex-gt-sm>
            <label>Correo Electrónico</label>
            <input ng-model="usuario.correo">
        </md-input-container>

        <md-input-container class="md-block" flex-gt-sm>
            <label>Celular</label>
            <input ng-model="usuario.celular">
        </md-input-container>

        <md-input-container class="md-block" flex-gt-sm>
            <label>Teléfono Fijo</label>
            <input ng-model="usuario.telefono">
        </md-input-container>

        <md-input-container class="md-block" flex-gt-xs>
            <label>Producto Interes 1</label>
            <md-select ng-model="user.interes1">
              <md-option value="CAFE">CAFE</md-option>
              <md-option value="PLATANO">PLATANO</md-option>
              <md-option value="MORA">MORA</md-option>
            </md-select>
        </md-input-container>

        <md-input-container class="md-block" flex-gt-xs>
            <label>Producto Interes 2</label>
            <md-select ng-model="user.interes2">
              <md-option value="CAFE">CAFE</md-option>
              <md-option value="PLATANO">PLATANO</md-option>
              <md-option value="MORA">MORA</md-option>
            </md-select>
        </md-input-container>

        <md-input-container class="md-block" flex-gt-xs>
            <label>Producto Interes 3</label>
            <md-select ng-model="user.interes2">
              <md-option value="CAFE">CAFE</md-option>
              <md-option value="PLATANO">PLATANO</md-option>
              <md-option value="MORA">MORA</md-option>
            </md-select>
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