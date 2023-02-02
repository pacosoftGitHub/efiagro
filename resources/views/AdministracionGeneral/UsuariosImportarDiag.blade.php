<md-dialog aria-label="IMPORTAR">
  <form ng-cloak>
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Importación de Usuario</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="cancel()">
            <md-icon md-font-icon="fa-times fa-lg fa-fw"></md-icon>
        </md-button>
      </div>
    </md-toolbar>

    <md-dialog-content>
      <div class="md-dialog-content">
          <table md-table >
              <thead md-head >
              <tr md-row>
                  <th md-column>Tipo Doc</th>
                  <th md-column>Documento</th>
                  <th md-column>Nombres</th>
                  <th md-column>Apellidos</th>
                  <th md-column>Edad</th>
                  <th md-column>Sexo</th>
                  <th md-column>Etnia</th>
                  <th md-column>Correo</th>
                  <th md-column>Celular</th>
                  <th md-column>Dirección</th>
                  <th md-column>Contraseña</th>
                  <th md-column>Departamento</th>
                  <th md-column>Municipio</th>
                  <th md-column>Vereda</th>
                  <th md-column>Finca</th>
                  <th md-column>Lat</th>
                  <th md-column>Lng</th>
              </tr>
              </thead>
              <tbody md-body >
                  <tr md-row ng-repeat="usuario in UsuariosImportar" ng-class="usuario.existe ? 'existe' : 'no-existe'">
                      <td md-cell>@{{ usuario.tipo_documento }}</td>
                      <td md-cell>@{{ usuario.documento }}</td>
                      <td md-cell>@{{ usuario.nombres }}</td>
                      <td md-cell>@{{ usuario.apellidos }}</td>
                      <td md-cell>@{{ usuario.edad }}</td>
                      <td md-cell>@{{ usuario.sexo }}</td>
                      <td md-cell>@{{ usuario.etnia }}</td>
                      <td md-cell>@{{ usuario.correo }}</td>
                      <td md-cell>@{{ usuario.celular }}</td>
                      <td md-cell>@{{ usuario.direccion_residencia }}</td>
                      <td md-cell>************</td>
                      <td md-cell>@{{ usuario.departamento }}</td>
                      <td md-cell>@{{ usuario.municipio }}</td>
                      <td md-cell>@{{ usuario.vereda }}</td>
                      <td md-cell>@{{ usuario.finca }}</td>
                      <td md-cell>@{{ usuario.latitud }}</td>
                      <td md-cell>@{{ usuario.longitud }}</td>
                  </tr>
              </tbody>
          </table>
      </div>
    </md-dialog-content>

    <md-dialog-actions layout="row">
      <span flex></span>
      <md-button ng-click="answer('not useful')">
       IMPORTAR
      </md-button>
      <md-button ng-click="answer('useful')">
        CANCELAR
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>
<style>
	.no-existe{
		background-color: #d9ffe4;
	}
	.existe{
		background-color: #ffd9d9;
	}
  td.md-cell{
    padding 0 !important;
  }
</style>