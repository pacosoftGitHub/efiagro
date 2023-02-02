angular.module('CreditoSrv', []).factory('CreditoSrv', [
  function (){
  	let Srv = {};

  	Srv.Scales = {
		 '1_M': { key:  '1_M', Nombre: 'Mensuales',		  Meses:  1,  PeriodosAno: 12 },
		 '2_M': { key:  '2_M', Nombre: 'Bimestrales',	  Meses:  2,  PeriodosAno:  6 },	
		 '3_M': { key:  '3_M', Nombre: 'Trimestrales',	  Meses:  3,  PeriodosAno:  4 },	
		 '4_M': { key:  '4_M', Nombre: 'Cuatrimestrales', Meses:  4,  PeriodosAno:  3 },		
		 '6_M': { key:  '6_M', Nombre: 'Semestrales',	  Meses:  6,  PeriodosAno:  2 },	
		'12_M': { key: '12_M', Nombre: 'Anuales',		  Meses: 12,  PeriodosAno:  1 },
	};

	Srv.ScalesRef = {
		'Mensuales': '1_M',		
		'Bimestrales': '2_M',
		'Trimestrales': '3_M',	
		'Cuatrimestrales': '4_M',
		'Semestrales': '6_M',
		'Anuales': '12_M',
	}

  	//Funcion de calculo de cuotas
	Srv.CalcCuotas = function(Monto, Interes, Scale, Periodos, Periodos_Gracia, Primer_Pago, Start_Pago){

		let Amortable = [];
		let AmortableRes = { Capital: 0, Interes: 0, Ajuste: 0, Total: 0 };

		let Meses = Srv.Scales[Scale].Meses;
		let PeriodosAno = Srv.Scales[Scale].PeriodosAno;
		//console.log('Interes', Interes);
		let TasaPer = Math.pow( (1 + (Interes) ), (1/PeriodosAno) ) - 1;
		let Periodos_Pago = Periodos - Periodos_Gracia;
		let FacAnu = TasaPer / (1 - ( 1/ ( Math.pow( ( 1 + TasaPer ), Periodos_Pago ) )  ));
		let Fec = angular.copy(moment(Primer_Pago)); //Fecha Inicial, Hoy

		let Deuda = angular.copy(Monto);

		let CuotaPer = Math.ceil(Monto * FacAnu);

		let Cuota = 0;

		

		for (let i = Start_Pago; i < (Periodos+Start_Pago); i++) {
			
			let Am = {
				Num_Pago: i,
				Capital: 0,
				Interes: 0,
				Total:   0,
				Deuda:   0,
			};

			Fec = Fec.add(Meses, 'M');

			Am.Fecha = Fec.format("YYYY-MM-DD");
			Am.Interes = Math.ceil( Deuda * TasaPer );

			if(i <= Periodos_Gracia){
				Am.Total = Am.Interes;
			}else{
				Am.Total = CuotaPer;
				Am.Capital = Am.Total - Am.Interes;
				Cuota = CuotaPer;
			}

			Deuda = Deuda - Am.Capital;
			if(Deuda < 50){
				Am.Capital = Am.Capital + Deuda;
				Am.Total   = Am.Total + Deuda;
				Deuda = 0;
			}
			Am.Deuda = Deuda;

			Amortable.push(Am);

			AmortableRes.Capital += Am.Capital;
			AmortableRes.Interes += Am.Interes;
			AmortableRes.Total += Am.Total;
		}

		return {
			Amortable: Amortable,
			AmortableRes: AmortableRes,
			Cuota: Cuota,
		}
	};


	return Srv;
  }
]);