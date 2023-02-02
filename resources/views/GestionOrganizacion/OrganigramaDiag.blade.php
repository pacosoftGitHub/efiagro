
<md-dialog class="vh95 w100p mxw550"  layout=column>

	<div class="titulo_close"layout="row" >
		<div flex=""><h2>Organigrama</h2></div>
		<div aling="right"> <md-button class="md-icon-button no-margin" aria-label="salir" ng-click="Salir()">
			<md-icon md-font-icon="fa-times fa-lg fa-fw"></md-icon>
		</md-button></div>
		
	</div>
	<div flex-gt-sm="50" flex>
		<md-content>
		  <md-list flex>
			
			<md-list-item class="md-3-line" >
			  <img src="/../imgs/avatar.jpeg" class="md-avatar" alt="" />
			  <div class="md-list-item-text" layout="column">
				<h3>Camila Uno</h3>
				<label class="texto_title">micorrego@gmail.com</label>
			  </div>
			</md-list-item>
			<md-list-item class="md-3-line" >
				<img src="/../imgs/avatar.jpeg" class="md-avatar" alt="" />
				<div class="md-list-item-text" layout="column">
					<h3>Carlos OTRO</h3>
					<label class="texto_title">micorrego@gmail.com</label>
				</div>
			  </md-list-item>
			  <md-list-item class="md-3-line" >
				<img src="/../imgs/avatar.jpeg" class="md-avatar" alt="" />
				<div class="md-list-item-text" layout="column">
				  <h3>Mario Otra Vez</h3>
				  <label class="texto_title">micorrego@gmail.com</label>
				</div>
			  </md-list-item>
			  <md-list-item class="md-3-line" >
				<img src="/../imgs/avatar.jpeg" class="md-avatar" alt="" />
				<div class="md-list-item-text" layout="column">
				  <h3>Camila Uno</h3>
				  <label class="texto_title">micorrego@gmail.com</label>
				</div>
			  </md-list-item>
			  <md-list-item class="md-3-line" >
				  <img src="/../imgs/avatar.jpeg" class="md-avatar" alt="" />
				  <div class="md-list-item-text" layout="column">
					  <h3>Carlos OTRO</h3>
					  <label class="texto_title">micorrego@gmail.com</label>
				  </div>
				</md-list-item>
			
		  </md-list>
		</md-content>
	  </div>
	
	 

	<div class="h120">&nbsp;</div>	

	

	

</md-dialog>

<style type="text/css">
	
	.seccion_organizacion{
		transform: scale(0.95);
		transition: all 0.3s;
		
	}
	.titilo-organizacion{
		text-align: center;
	}
	.titulo_close{
		padding: 1.5%;

	}

	.seccion_organizacion:hover{
		transform: scale(1)	;
	}
	md-card{
		min-height: 200px;

	}
	.img-organizacion{
		width: 100px;
		height: 100px;
		border-radius: 500px;
	
	}
	.seccion_texto{
		white-space:normal;
		word-wrap: break-word;
	}

	.texto_title{
		/* text-align: center;
		height: 40px; */
		color: rgb(199, 196, 196);
		/* font-size: 1.2rem;
		text-shadow: 0 0 5px black; */	
	}

</style>