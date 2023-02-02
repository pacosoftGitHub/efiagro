<md-dialog class="vh95 mxw850 mw650 overflow-x bg-dark" layout=column>

	<div layout="row" layout-align="space-between start">
		<div layout="column" layout-align="start" class="padding-20">
			<div layout layout-align="space-between center ">
				<div>
					<h3 class="md-title no-margin">Caso # @{{ Caso.id }}</h3>
				</div>
			</div>
			<div class="text-bold text-14px">
				@{{ Caso.tipo }} ( @{{ Caso.solicitante.nombre }} )
			</div>
		</div>
		<md-button ng-click="Cancel()" class="md-icon-button no-margin text-red">
			<md-icon md-font-icon="fa-times fa-lg fa-fw"></md-icon>
			<md-tooltip md-direction="bottom">Cerrar modal</md-tooltip>
		</md-button>
	</div>
	<h3 class="md-title padding-0-20">@{{ Caso.titulo }}</h3>
	
	<!--
	<div layout=column flex class="overflow-y padding-0-20">
		<div ng-repeat="N in NovedadesCRUD.rows" class="footnote" >
			<div class="bg-light-grey" style="border-radius: 5px; padding: 5px;">
				<p class="md-title">@{{ N.created_at | date:'longDate' }} - @{{ N.autor.nombres }} @{{ N.autor.apellidos }} </p>
				<div ng-if="N.tipo == 'Texto'">
					<p>@{{ N.novedad }}</p>
				</div>
				<div ng-if="N.tipo == 'Imagen'"  class="text-center">
					<img ng-src="@{{ N.novedad }}" alt="">
				</div>
			</div>
			<p></p>
		</div>
	</div>-->

	<!--Seccion de chat-->
	<div layout=column flex class="overflow-y padding-0-20">
	<div class="container clearfix">
		<div class="chat">
			<div class="chat-header clearfix">
			<div class="chat-history">
				<ul>
					<div ng-repeat="N in NovedadesCRUD.rows">
						<li  ng-if="N.usuario_id != 1" class="clearfix">
							<p></p>
							<div class="message-data align-right">
								<span class="message-data-time" >@{{ N.created_at | date:'longDate' }}</span> &nbsp; &nbsp;
								<span class="message-data-name" > @{{ N.autor.nombres }} @{{ N.autor.apellidos }}</span> <i class="fa fa-circle me"></i>	
							</div>
							<div class="message other-message float-right">
								<div ng-if="N.tipo == 'Texto'">
									<p>@{{ N.novedad }}</p>
								</div>
								<div ng-if="N.tipo == 'Imagen'"  class="text-center">
									<p>
										<img ng-src="@{{ N.novedad }}" alt="">
									</p>
								</div>
							</div>
						</li>
						<li  ng-if="N.usuario_id == 1">
							<div class="message-data">
								<span class="message-data-name"><i class="fa fa-circle online"></i> @{{ N.autor.nombres }}</span>
								<span class="message-data-time">@{{ N.created_at | date:'longDate' }}</span>
							</div>
							<div class="message my-message">
								<div ng-if="N.tipo == 'Texto'">
									<p>@{{ N.novedad }}</p> 
								</div>
								<div ng-if="N.tipo == 'Imagen'"  class="text-center">
									<p>
										<img ng-src="@{{ N.novedad }}" alt="">
									</p>
								</div>
							</div>
						</li>
					</div>
				</ul>
				
				</div> <!-- end chat-history -->
			</div> <!-- end chat -->
		
		</div> <!-- end container -->
	</div>
	<!--Fin seccion chat-->
	
	<div layout class=" padding-5-10" layout-align="space-between start">
		<md-input-container class="no-margin md-title mw650 w80p" >
			<textarea id="casnovedad" ng-model="detallecaso" placeholder="Registrar la novedad" rows="3"></textarea>
		</md-input-container>
		<div layout="column" layout-align=" center">
			<md-button class="md-raised md-primary no-margin" ng-click="crearNovedad('Texto', detallecaso)">
				Agregar
			</md-button>
			<md-button ng-click="crearNovedad('Imagen', detallecaso)">
				<md-icon md-font-icon="fa-image fa-lg fa-fw"></md-icon>
				<md-tooltip md-direction="bottom">Agregar imagen</md-tooltip>
			</md-button>
		</div>
	</div>
</md-dialog>

<style>
	li {
		list-style:none
	}

	.people-list .search {
		padding: 20px;
	}

	.people-list .fa-search {
		position: relative;
		left: -25px;
	}
	.people-list ul {
		padding: 20px;
		height: 770px;
	}
	.people-list ul li {
		padding-bottom: 20px;
	}
	.people-list img {
		float: left;
	}
	.people-list .about {
		float: left;
		margin-top: 8px;
	}
	.people-list .about {
		padding-left: 8px;
	}
	.people-list .status {
		color: #92959e;
	}
	.chat {
		float: left;
		background: #f2f5f8;
		border-top-right-radius: 5px;
		border-bottom-right-radius: 5px;
		color: #434651;
	}
	.chat .chat-header {
		padding: 20px;
		border-bottom: 2px solid white;
	}
	.chat .chat-header img {
		float: left;
	}
	.chat .chat-header .chat-about {
		float: left;
		padding-left: 10px;
		margin-top: 6px;
	}
	.chat .chat-header .chat-with {
		font-weight: bold;
		font-size: 16px;
	}
	.chat .chat-header .chat-num-messages {
		color: #92959e;
	}
	.chat .chat-header .fa-star {
		float: right;
		color: #d8dadf;
		font-size: 20px;
		margin-top: 12px;
	}

	.chat .chat-history .message-data {
		margin-bottom: 15px;
	}
	.chat .chat-history .message-data-time {
		color: #a8aab1;
		padding-left: 6px;
	}
	.chat .chat-history .message {
		color: white;
		padding: 18px 20px;
		line-height: 26px;
		font-size: 16px;
		border-radius: 7px;
		margin-bottom: 30px;
		width: 90%;
		position: relative;
	}
	.chat .chat-history .message:after {
		bottom: 100%;
		left: 7%;
		border: solid transparent;
		content: " ";
		height: 0;
		width: 0;
		position: absolute;
		pointer-events: none;
		border-bottom-color: #86bb71;
		border-width: 10px;
		margin-left: -10px;
	}
	.chat .chat-history .my-message {
		background: #86bb71;
	}
	.chat .chat-history .other-message {
		background: #94c2ed;
	}
	
	.chat .chat-history .other-message:after {
		border-bottom-color: #94c2ed;
		left: 93%;
	}
	.chat .chat-message {
		padding: 30px;
	}
	.chat .chat-message textarea {
		width: 100%;
		border: none;
		padding: 10px 20px;
		font: 14px/22px "Lato", Arial, sans-serif;
		margin-bottom: 10px;
		border-radius: 5px;
		resize: none;
	}
	.chat .chat-message .fa-file-o, .chat .chat-message .fa-file-image-o {
		font-size: 16px;
		color: gray;
		cursor: pointer;
	}
	.chat .chat-message button {
		float: right;
		color: #94c2ed;
		font-size: 16px;
		text-transform: uppercase;
		border: none;
		cursor: pointer;
		font-weight: bold;
		background: #f2f5f8;
	}
	.chat .chat-message button:hover {
		color: #75b1e8;
	}
	.online, .offline, .me {
		margin-right: 3px;
		font-size: 10px;
	}
	.online {
		color: #86bb71;
	}
	.offline {
		color: #e38968;
	}
	.me {
		color: #94c2ed;
	}
	.align-left {
		text-align: left;
	}
	.align-right {
		text-align: right;
	}
	.float-right {
		float: right;
	}
	.clearfix:after {
		visibility: hidden;
		display: block;
		font-size: 0;
		content: " ";
		clear: both;
		height: 0;
	}
</style>