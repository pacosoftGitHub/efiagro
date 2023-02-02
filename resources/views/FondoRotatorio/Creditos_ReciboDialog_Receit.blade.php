<div class="Recibo Recibo_{{ $Version }}">
	<div class="ReciboHeader" layout layout-align="start center"><!-- Header -->
		<div class="w100">
			<img ng-src="@{{ 'imgs/organizaciones/'+Organizacion.id+'.jpg' }}" height="70">
		</div>
		
		<div flex layout="column" class="text-center">
			<span class="md-subhead"><b>@{{ Organizacion.nombre }}</b></span>
			<span class="md-body-1">NIT. @{{ Organizacion.nit }}</span>
			<span class="md-body-1">Tel. @{{ Organizacion.telefono }}</span>
		</div>

		<div class="w100 text-right" layout="column">
			<span class="md-title">No.@{{ Recibo.id }}</span>
			<span>@{{ Recibo.dia }}</span>
			<span class="md-caption receit_caption">{{ $Version }}</span>
		</div>
	</div>

	<div class="ReciboBody" layout="column"><!-- Body -->
		
		<div class="Row" layout> <!-- Row Nombre -->
			<div class="Cell" flex="40">
				<label>Asociado</label>
				<span>@{{ Asociado.nombre }}</span>
			</div>
			<div class="Cell" flex="15">
				<label>Documento</label>
				<span>@{{ Asociado.documento }}</span>
			</div>
			<div class="Cell" flex="15">
				<label>Teléfono</label>
				<span>@{{ Asociado.celular }}</span>
			</div>
			<div class="Cell" flex="30">
				<label>Email</label>
				<span>@{{ Asociado.correo }}</span>
			</div>
		</div>

		<div class="Row" layout> <!-- Row Finca -->
			<div class="Cell" flex="30">
				<label>Finca</label>
				<span>@{{ Asociado.fincas[0].nombre }}</span>
			</div>
			<div class="Cell" flex="40">
				<label>Dirección</label>
				<span>@{{ Asociado.fincas[0].direccion }}</span>
			</div>
			<div class="Cell" flex="30">
				<label>Distrito o Corregimiento</label>
				<span>@{{ Asociado.fincas[0].municipio_id +' / '+ Asociado.fincas[0].departamento_id }}</span>
			</div>
		</div>

		<div class="Row" layout> <!-- Row Credito -->
			<div class="Cell" flex="5">
				<label>Cod.</label>
				<span>@{{ CredSel.id }}</span>
			</div>
			<div class="Cell" flex="25">
				<label>Monto Solicitado</label>
				<span>@{{ CredSel.monto | currency:"$":0 }}</span>
			</div>
			<div class="Cell" flex="40">
				<label>Línea</label>
				<span>@{{ CredSel.linea }}</span>
			</div>
			<div class="Cell" flex="15">
				<label>Interés (EA)</label>
				<span>@{{ CredSel.interes }}%</span>
			</div>
			<div class="Cell" flex="15">
				<label>Pagos</label>
				<span>@{{ CredSel.pagos }}</span>
			</div>
		</div>
		<div class="Row border-bottom" layout>
			<div class="Cell" flex="20">
				<label>Periodos</label>
				<span>@{{ CredSel.periodos }}</span>
			</div>
			<div class="Cell" flex="20">
				<label>Per. Gracia</label>
				<span>@{{ CredSel.periodos_gracia }}</span>
			</div>
			<div class="Cell" flex="30">
				<label>Cuota</label>
				<span>@{{ CredSel.cuota | currency:"$":0 }}</span>
			</div>
			<div class="Cell" flex>
				<label>Solicitado</label>
				<span><nobr>@{{ CredSel.solicitado }}</nobr></span>
			</div>
		</div>

		@include('FondoRotatorio.Creditos_CreditList_Pagos_Table')

		<div class="Row" layout> <!-- Row Recibo -->
			<div class="Cell" flex="20">
				<label>Valor Recibido</label>
				<span>@{{ Recibo.valor_recibido | currency:"$":0 }}</span>
			</div>
			<div class="Cell" flex>
				<label>Medio</label>
				<span>@{{ Recibo.medio }}</span>
			</div>
			<div class="Cell" flex="25" ng-if="Recibo.NoConsignacion !== null">
				<label>No. Consignación</label>
				<span>@{{ Recibo.no_consignacion }}</span>
			</div>
			<div class="Cell" flex="40">
				<label>Total Pagado</label>
				<span>@{{ Recibo.valor | currency:"$":0 }}</span>
			</div>
		</div>
	</div>

	<div class="h20"></div>

	<div class="ReciboFoot margin-top" layout="column">
		<div layout class="md-caption">
			<div flex="10"></div>
			<div class="border-top" flex>
				<b>@{{ Asociado.nombre }}</b>
				<br>Asociado
			</div>
			<div flex="10"></div>
			<div class="border-top" flex>
				<b>@{{ MyUser.nombre }}</b>
				<br>Funcionario
			</div>
			<div flex="10"></div>
		</div>

	</div>


</div>