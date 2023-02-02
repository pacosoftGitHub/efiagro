<div id="FincaEventos" ng-controller="FincaEventosCtrl" flex layout="column" class="mxw1000">
<div class="mxw900">
            <md-button class="md-raised md-primary" aria-label="Nueva" ng-click="nuevoEvento()">
                <md-icon md-font-icon="fa-plus fa-lg fa-fw"></md-icon>Agregar Evento
            </md-button>
        </div>
    <div ng-repeat="FE in FincaEventosCRUD.rows">
    
        <md-card >
            <div layout="row"  layout-align="space-between center" >
                <div layout class="w100p mxw600 bg-white padding-5-20 border-rounded">
                    <img ng-src="files/eventos_media/@{{ FE.evento_id }}.jpg" alt="" width="60" height="60">
                    <div class="seccion_texto">
                        
                        <ul ><span class="textoInfo">@{{ FE.fecha | date:'yyyy-MM-dd'}}/</span><label class="texto_title"> @{{ FE.evento.evento }}</label></ul> 
                        <ul ><span class="textoInfo">Finca/</span><label class="texto_title"> @{{ FE.finca.nombre }}</label></ul> 
                        <ul ><span class="textoInfo"></span><label class="textoInfo"> @{{ FE.observacion }}</label></ul> 
                                  
                    </div>
                <div>
                    <ul ><span class="textoInfo">Gravedad</span><label class="texto_title"> @{{ FE.gravedad }}</label></ul>

                </div>
                </div>
              
            </div>
           
        </md-card>
        
    </div>
    

</div>

<style type="text/css">
   
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
