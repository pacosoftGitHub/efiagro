<div style="position:absolute;bottom:50px;left:15px;z-index:0;" ng-show="Estado.ruta.length == 2" >
	<img src="imgs/logo_pacosoft.png" /></div>
	
<div flex id="Home" ng-controller="HomeCtrl" layout=column>
	<div class="bg-primary" layout layout-align="center center"
		style="padding-left: 30px">
		<md-button class="" href="#/Home" >
			<img src="imgs/logo_pequeno_main_nav.png?id=<?php echo uniqid(time()); ?>" aria-label="">
		</md-button>
		<div class="w30"></div>   
		<md-select  ng-show="listaOrganizacion" 
					ng-change="actualizarUsuario('organizacion_id', Usuario.organizacion_id)"
					ng-model="Usuario.organizacion_id" class="no-margin" aria-label="Organizacion" >
			<md-option ng-value="" >Sin Organización</md-option>
			<md-option 
					ng-value="O.id" 
					ng-repeat="O in Usuario.organizaciones">@{{ O.nombre }}</md-option>
		</md-select>
		<md-select 	ng-show="listaFinca" 
					ng-model="Usuario.finca_id" 
					ng-change="actualizarUsuario('finca_id', Usuario.finca_id)" class="no-margin" aria-label="Finca" >
			<md-option 
					ng-value="F.id"
					ng-repeat="F in Usuario.fincas">@{{ F.nombre }}</md-option>
		</md-select>

		<span flex></span>
		<div>@{{ Usuario.nombre }} </div>
		<div>
			<md-menu>
				<md-button ng-click="$mdMenu.open($event)" class="md-icon-button no-margin" aria-label="Menu">
					<md-icon md-svg-icon="md-more-v"></md-icon>
				</md-button>
				<md-menu-content>
						<md-button class="md-warn" ng-click="cambiarClave(Usuario)">
							<md-icon md-font-icon="fa-key"></md-icon>
							Cambiar Contraseña </md-button></md-menu-item>
					<md-menu-item ng-show=" !$last ">
						<md-button class="md-warn" ng-click="Logout()">
							<md-icon md-font-icon="fa-power-off fa-lg">						
						</md-icon>
							Cerrar Sesión</md-button></md-menu-item>
				</md-menu-content>
			</md-menu>
		</div>
	</div>

	<div flex ui-view layout=column class="overflow-y">
		<div flex layout layout-align="space-around center" layout-wrap>
			<a ng-repeat="S in Secciones" href="#/Home/@{{ S[0].seccion_slug }}/@{{ S[0].subseccion_slug }}"
				class="seccion_icono no-underline" layout=column>
				<div class="seccion_icono_img"><img ng-src="imgs/icono_@{{ S[0].id }}.png" /></div>
				<div class="seccion_icono_texto">@{{ S[0].seccion }}</div>
			</a>
			<div flex=100 class="h50"></div>
		</div>	
	</div>
</div>

<style type="text/css">

	.main-nav{
		background-color: #316756;
		box-shadow: 0 2px 5px #555;
	}
	
	.seccion_icono{
		position: relative;
		
		margin: 20px;
		transition: all 0.3s;
		
	}

	.seccion_icono:hover{
		transform: scale(1.1)	;
	}

	.seccion_icono_texto{
		text-align: center;
		color: #000;
		font-size: 1.2rem;
		text-shadow: 0 0 2px black;
	}

	.seccion_icono_img{
		position: relative;
		width: 160px;
		height: 160px;
		
		margin: 5px;
		border-radius: 50%;
		/*background-image: url("imgs/default-section-icon.png");*/
		background-size: 100%;
	}
	.seccion_icono_img img{
		width: 160px;
		height: 160px;
	}

</style>


</style>