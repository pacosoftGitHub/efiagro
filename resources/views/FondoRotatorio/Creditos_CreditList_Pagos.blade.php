<md-card class="Cred__Recibo" ng-repeat="Recibo in CredSel.recibos" layout="column">
	
	<div class="Recibo_Head" layout layout-wrap>
		<span class="md-title margin" flex="20">Cod. @{{ Recibo.id }}</span>
		<span class="md-subhead margin" flex="30">@{{ Recibo.fecha }}</span>
		<span flex></span>
		<span class="md-title margin">@{{ Recibo.valor | currency:"$":0 }}</span>
		<md-button class="md-icon-button" aria-label="Print" ng-click="PrintRecibo($event, Recibo)">
			<md-tooltip md-direction="down">Imprimir Recibo</md-tooltip>
			<md-icon md-font-icon="fa-print" class="fa-lg"><md-icon>
		</md-button>
		<md-button class="md-icon-button" aria-label="Delete" ng-click="DeleteRecibo($event, Recibo)">
			<md-tooltip md-direction="down">Borrar Recibo</md-tooltip>
			<md-icon md-font-icon="fa-trash" class="fa-lg"><md-icon>
		</md-button>
	</div>

	@include('FondoRotatorio.Creditos_CreditList_Pagos_Table')

</md-card>