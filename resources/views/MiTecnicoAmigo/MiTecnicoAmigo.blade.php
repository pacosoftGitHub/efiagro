<div flex layout=column ng-controller="MiTecnicoAmigoCtrl" style="z-index: 2;">

	<div class="div_bienvenida md-title padding-top padding-left">
        ¡Bienvenido!, ¿Cómo le puedo ayudar? 
    </div>
    <div layout=column flex layout-align="start" class="padding">
        <md-button class="md-raised boton-principal mxw350" ng-click="navegarA('Articulos')">
            Ver los Artículos publicados
        </md-button>
        <md-button class="md-raised boton-principal mxw350" ng-click="crearCaso(1)">
            Contar una experiencia
        </md-button>
        <md-button class="md-raised boton-principal mxw350" ng-click="navegarA('Solicitudes')">
            Contactar a Técnico Amigo
        </md-button>
    </div>
</div>
<img src="imgs/paco1.png" alt="" style="position:absolute;z-index:1;bottom:0;right:0;width:auto;height:550px;" id="paco" >
<style type="text/css">
	.boton-principal{
        min-width: 300px;
		border-radius: 100px;
		padding: 6px 30px;
		font-size: 1.1em;
		text-shadow: 1px 1px 1px #00000066;
	}
    .div_bienvenida{
        /* color: aliceblue; */
        font-size: 2em;
    }
</style>