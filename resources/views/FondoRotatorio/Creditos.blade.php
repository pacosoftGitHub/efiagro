<div id="Creditos" flex ng-controller="FondoRotatorio_CreditosCtrl" layout>
	
	<md-sidenav class="w230 " md-whiteframe=4
		md-is-locked-open="AsociadosNav">
		
		<div class="h40 bg-primary text-16px lh40 padding-left"><span class="text-clear">Buscar Asociado</span></div>
		<md-autocomplete 
			md-selected-item="Asociado"
			md-autoselect="true"
			md-search-text="asociadosQuery"
			md-selected-item-change="selectAsociado(Asociado)"
			md-items="Asociado in buscarAsociados(asociadosQuery)"
			md-item-text="Asociado.nombres+' '+Asociado.apellidos"
			md-delay="500"
			md-min-length="2"
			placeholder="Buscar Asociado"
			class="margin"
			ng-disabled="Asociado">
			<md-item-template>
				@{{ Asociado.nombres }} @{{ Asociado.apellidos }}
			</md-item-template>
			<md-not-found>Sin coincidencias</md-not-found>
		</md-autocomplete>

		<div flex layout=column class="padding-0-10" ng-show="Asociado">
			
			@include('FondoRotatorio.Creditos_UsuarioForma')

		</div>

		<div layout ng-show="Asociado" class="border-top">
			<md-button ng-click="Asociado = null">Salir</md-button>
		</div>

	</md-sidenav>

	<div flex layout="column" ng-show="Asociado">

    	<md-toolbar class="md-short">
				<div class="md-toolbar-tools bg-primary" layout>
					<md-button ng-click="AsociadosNav = !AsociadosNav" class="md-icon-button" aria-label="p">
						<md-icon md-svg-icon="md-bars"></md-icon>
					</md-button>

					<md-button ng-click="CredSel = null" aria-label="b" ng-show="CredSel" class="no-margin-left no-padding-left">
						<md-icon md-font-icon="fa-chevron-left"></md-icon>&nbsp;&nbsp;Volver a Creditos
					</md-button>
 
					<span class="text-16px text-clear" ng-show="!CredSel">Créditos de @{{ Asociado.nombre }}</span>

					<span flex></span>

					<md-menu md-position-mode="target-right target" >
						<div ng-click="$mdMenu.open()">
							<md-button class="md-icon-button no-margin" aria-label="Dot"><md-icon md-svg-icon="md-more-v"></md-icon></md-button>
						</div>

						<md-menu-content>
							<md-menu-item>
								<md-button ng-click="DownloadCreditsList($event)">
									<md-icon md-font-icon="fa-list" class=" fa-fw"></md-icon>Descargar Créditos
								</md-button>
							</md-menu-item>
							<md-menu-item ng-show="CredSel">
								<md-button ng-click="PrintCredit($event)">
									<md-icon md-font-icon="fa-print" class=" fa-fw"></md-icon>Imprimir Comprobante
								</md-button>
							</md-menu-item>
							<md-menu-item ng-show="CredSel">
								<md-button class="md-warn" ng-click="DeleteCredit($event)">
									<md-icon md-font-icon="fa-trash" class=" fa-fw"></md-icon>Eliminar Crédito
								</md-button>
							</md-menu-item>
						</md-menu-content>
					</md-menu>

				</div>
		</md-toolbar>			

		@include('FondoRotatorio.Creditos_CreditosLista')
		@include('FondoRotatorio.Creditos_CreditDetail')

    	</div>

    </div>

</div>
