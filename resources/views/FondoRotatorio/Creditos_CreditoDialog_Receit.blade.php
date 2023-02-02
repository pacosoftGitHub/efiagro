<div class="Recibo">
	<div class="ReciboHeader" layout layout-align="start center"><!-- Header -->
		<div class="w130">
			<img ng-src="@{{ '/files/img_perfil_organizacion/'+CredSel.organizacion_id+'.jpg' }}" height="70">
		</div>
		
		<div flex layout="column" class="text-center">
			<span class="md-subhead"><b>@{{ Organizacion.nombre }}@{{Usuario.organizacion_id}}</b></span>
			<span class="md-body-1">NIT. @{{ Organizacion.nit }}</span>
			<span class="md-body-1">Tel. @{{ Organizacion.telefono }}</span>
		</div>

		<div class="w130 text-right" layout="column">
			<span>Crédito</span>
			<span class="md-title">Cod. @{{ CredSel.id }}</span>
			<span>@{{ Hoy }}</span>
			<span hide class="md-caption receit_caption"></span>
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
			<div class="Cell" flex="20">
				<label>Estado</label>
				<span ng-style="{ color: CredSel.Estado_color }">@{{ CredSel.Estado }}</span>
			</div>
			<div class="Cell" flex="20">
				<label>Monto Solicitado</label>
				<span>@{{ CredSel.monto | currency:"$":0 }}</span>
			</div>
			<div class="Cell" flex="30">
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

		<span class="md-subhead text-center margin-top text-clear"><b>Detalle de Cuotas</b></span>
		<div class="text-xs border-bottom no-overflow no-overflow-all">
			@include('FondoRotatorio.Creditos_CreditList_Cuotas')
		</div>

		<span class="md-subhead text-center margin-top text-clear"><b>Detalle de Pagos</b></span>
		<div class="text-xs border-bottom no-overflow no-overflow-all">
			@include('FondoRotatorio.Creditos_CreditList_ListPagos')
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
				<b>@{{ Organizacion.nombre_rl }}</b>
				<br>Representante Legal
			</div>
			<div flex="10"></div>
		</div>

	</div>

</div>