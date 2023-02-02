<div id="Login" ng-controller="LoginCtrl" flex layout layout-align = "center top">

	<div class="login" layout="column" style="width: 100%;">
		<div flex="70" style="padding: 20px;">
			<img src="imgs/logo_home.png?id=<?php echo uniqid(time()); ?>" style="display: block; margin: 0 auto;" />
			<md-card class="mw300" style="width: 500px;margin: 0 auto;">
				<form  ng-submit="enviarLogin($event)">
					<md-card-content flex layout=column>
						{{-- <div class="border-rounded" > --}}
							<div  align="center">
								<img class="imagen" src="imgs/login_icon.png"  alt="" >
							</div>
						{{-- </div> --}}

						<md-input-container class="md-icon-float">
							<label>Cedula / N.I.T</label>
							<md-icon md-font-icon="fa-user fa-fw"></md-icon>
							<input type="text" ng-model="Usuario.Correo" required>
						</md-input-container>
						<md-input-container class="md-icon-float">
							<label>Contraseña</label>
							<md-icon md-font-icon="fa-key fa-fw"></md-icon>
							<input type="password" ng-model="Usuario.Password" required>
						</md-input-container>
					</md-card-content>
					<md-card-actions layout layout-align="center center">
						<a class="md-body-1 padding-left" href="#/Recuperar">Olvidé mi contraseña</a>
						<span flex></span>
						<md-button class="md-raised md-primary" type=submit>Ingresar</md-button>
					</md-card-actions>
				</form>
			</md-card>
		</div>
		<div flex="30" layout="row" layout-xs="column" align="center" style="padding: 20px;">
			<div flex="">
				<div><b>CON EL APOYO DE</b></div>
				<img src="imgs/mincomercio.jpg" class="img-res" />
				<img src="imgs/innpulsa.jpg" class="img-res" />
			</div>
			<div flex="">
			<div><b>CON LA PARTICIPACION DE</b></div>
				<img src="imgs/minciencias.jpg" class="img-res" />
				<img src="imgs/sena_gc.jpg" class="img-res" />
			</div>
		</div>
	</div>
	<!--
	<div class="logos">
		<span class='spacer'></span>
		<div align="center"><img class="" src="imgs/logos_entidades.png"  alt="" ></div>
		<span class='spacer'></span>
	</div>
	/-->
</div>

<style type="text/css">
.login{
	margin
}

.logos{
	position: absolute;
	bottom: 0;
}
/* .border-rounded{
	widows: 200px;
	height: 200px;
	background-color: lightgray;
	margin: auto;
} */
.imagen{
	width: 130px;
	height: 130px;
}

.img-res{
	width:auto;
	height: 60px;
	vertical-align: top;
}

</style>