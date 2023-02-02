<div id="MiFinca" class="divFinca" ng-controller="FincasMifincaCtrl" layout="row" layout-wrap="" class="">

    {{-- SECCIÓN MI FINCA --}}

    <div flex="100" flex-gt-sm="30" >
        <md-card flex class="no-margin-top">
            <md-table-container>
                <table md-table>
                    <thead md-head>
                        <tr md-row>
                            <th md-column width="30%">DATOS</th>
                            <th md-column width="70%">DETALLE</th>
                        </tr>
                    </thead>
                    <tbody md-body>
                        <tr md-row>
                            <td md-cell class="negrilla">Nombre</td>
                            <td md-cell>@{{ Finca.nombre }}</td>
                        </tr>
                        <tr md-row>
                            <td md-cell class="negrilla">Dirección</td>
                            <td md-cell>@{{ Finca.direccion }}</td>
                        </tr>
                        <tr md-row>
                            <td md-cell class="negrilla">Departamento</td>
                            <td md-cell>@{{ Finca.nombreDepartamento }}</td>
                        </tr>
                        <tr md-row>
                            <td md-cell class="negrilla">Municipio</td>
                            <td md-cell>@{{ Finca.nombreMunicipio }}</td>
                        </tr>
                        <tr md-row>
                            <td md-cell class="negrilla">Área Total</td>
                            <td md-cell>@{{ Finca.area_total }}</td>
                        </tr>
                        <tr md-row>
                            <td md-cell class="negrilla">Tipo Cultivo</td>
                            <td md-cell>@{{ Finca.tipo_cultivo }}</td>
                        </tr>
                        <tr md-row>
                            <td md-cell class="negrilla">Tipo Suelo</td>
                            <td md-cell>@{{ Finca.tipo_suelo }}</td>
                        </tr>
                        <tr md-row>
                            <td md-cell class="negrilla">Zona</td>
                            <td md-cell>@{{ Finca.zona.descripcion }}</td>
                        </tr>
                        <tr md-row>
                            <td md-cell class="negrilla">Sitios</td>
                            <td md-cell>@{{ Finca.sitios }}</td>
                        </tr>
                    </tbody>
                </table>
            </md-table-container>
        </md-card>
        <!--
            <div >
                <ul ><label class="texto_title">Dirección:</label> <span class="textoInfo">@{{ Finca.nombre }}</span></ul>
                <ul ><label class="texto_title">Dirección:</label> <span class="textoInfo">@{{ Finca.direccion }}</span></ul>
                <ul ><label class="texto_title">Departamento:</label> <span class="textoInfo">@{{ Finca.departamento_id }} - @{{ Finca.nombreDepartamento }}</span></ul>
                <ul ><label class="texto_title">Municipio:</label> <span class="textoInfo">@{{ Finca.municipio_id }} - @{{ Finca.nombreMunicipio }}</span></ul>
                <ul ><label class="texto_title">Área total:</label> <span class="textoInfo">@{{ Finca.area_total }}</span></ul>
                <ul ><label class="texto_title">Tipo Cultivo:</label> <span class="textoInfo">@{{ Finca.tipo_cultivo }}</span></ul>
                <ul ><label class="texto_title">Total de lotes:</label> <span class="textoInfo">@{{ Finca.total_lotes }}</span></ul>
                <ul ><label class="texto_title">Tipo de suelo:</label> <span class="textoInfo">@{{ Finca.tipo_suelo }}</span></ul>
                <ul ><label class="texto_title">Zona:</label> <span class="textoInfo">@{{ Finca . zona.descripcion }}</span></ul>
                <ul ><label class="texto_title">Hectareas:</label> <span class="textoInfo">@{{ Finca.hectareas }}</span></ul>
                <ul ><label class="texto_title">Latitud:</label> <span class="textoInfo">@{{ Finca.latitud }}</span></ul>
                <ul ><label class="texto_title">Longitud:</label> <span class="textoInfo">@{{ Finca.longitud }}</span></ul>
                <ul ><label class="texto_title">Sitio:</label> <span class="textoInfo">@{{ Finca.sitios }}</span></ul>
            </div>
        </div>
        //-->
    </div>
    <div flex="100" flex-gt-sm="70" layout-wrap="" class="divMap">
        <div mapa id="map" style="width:100%; height: 400px;overflow: hidden;"></div>
    </div>

</div>

<style type="text/css">
    .negrilla{
        font-weight: bold;
    }
    .divFinca {
        width:100%;
        height: fit-content;
        margin: 10px;
        padding: 10px;
        background: rgb(250, 250, 250);
        background: linear-gradient(0deg, rgba(250, 250, 250, 1) 0%, rgba(255, 255, 255, 0.4066001400560224) 20%, rgba(255, 255, 255, 1) 100%);
    }

    .divInfo {
        padding: 30px;
    }

    .divMap {
        padding: 30px;

    }

    .seccion_texto {
        white-space: normal;
        word-wrap: break-word;
    }
    .texto_title {
        font-weight: bold;
    }  
    .textoInfo {
        /* color: rgb(0, 0, 0); */
        color: rgb(58, 57, 57);
   }
   .img-lote {
        width: 50px;
        height: 50px;
        /* border-radius: 500px; */
    }

</style>