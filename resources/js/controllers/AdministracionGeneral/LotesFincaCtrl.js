angular.module("LotesFincaCtrl", []).controller("LotesFincaCtrl", [
    "$scope",
    "$rootScope",
    "$http",
    "$injector",
    "$mdDialog",
    function($scope, $rootScope, $http, $injector, $mdDialog) {

        var Ctrl = $scope;
        var Rs = $rootScope;
        //INICIO DEV ANGÉLICA
        Ctrl.indice = 0;
        var myChart;
        
        Ctrl.semanas = [];
        Ctrl.LotesLabores = [];
        Ctrl.LaboresProductor = [];
        //FIN DEV ANGELICA
        
        //INICIO DEV ANGELICA
        Ctrl.getLoteLabores = (lote, lineaproductiva, semana, fechaInicial, fechaFinal) => {
            Ctrl.LotesLabores = [];
            
            $http.get ('api/lotelabores/lotelaborsemana/'+ lote + '/' + lineaproductiva + '/' + semana, {}).then((r)=>{
                Ctrl.editable = new Date().toISOString().slice(0, 10) >= fechaInicial && new Date().toISOString().slice(0, 10) <= fechaFinal;  
				Ctrl.LotesLabores = r.data;
                console.log(Ctrl.editable);
			});
        };

        // Definición de LOTE LABORES PRODUCTOR
        Ctrl.LoteLaboresProductorCRUD = $injector.get("CRUD").config({
            base_url: "/api/loteslaboresproductor/loteslaboresproductor",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            query_with:['labor', 'lote']
        });

        // Definición de LOTE LABORES
        Ctrl.LoteLaboresCRUD = $injector.get("CRUD").config({
            base_url: "/api/lotelabores/lotelabores",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            query_with:['labor', 'lote']
        });

        //Definición de lote cosechas
        Ctrl.CosechasCRUD = $injector.get("CRUD").config({
            base_url: "/api/lotecosechas/lotecosechas",
            limit: 1000,
            add_append: "refresh"
        });

        Ctrl.getLaboresProductor = (lote, semana_id) => {
            Ctrl.LotesLabores = [];
            $http.get ('/api/loteslaboresproductor/loteslaboresproductor/'+ lote + '/' + semana_id, {}).then((r)=>{
                Ctrl.LaboresProductor = r.data;
			});
        };


        Ctrl.getLoteCosechas = (lote, fecha) => {
            Ctrl.LotesLabores = [];
            let datos = [];
            let labels = [];
            let colors = [];
            let suma = 0;
            let sumaKg = 0; 
            $http.get ('api/lotecosechas/cosechalote/'+ lote + '/' + fecha , {}).then((r)=>{
				Ctrl.LotesCosechas = r.data;
                Ctrl.LotesCosechas.forEach(loteCosecha => {
                    datos.push(loteCosecha.cantidad);
                    labels.push([loteCosecha.fecha, loteCosecha.cantidad, loteCosecha.kilogramo, loteCosecha.tipo]);
                    colors.push('rgba(13, 139, 22, 1)');
                    suma = suma + loteCosecha.cantidad;
                    sumaKg = sumaKg + loteCosecha.kilogramo;
                });
                datos.push(suma / Ctrl.LotesCosechas.length);
                labels.push(["Prom", suma / Ctrl.LotesCosechas.length, sumaKg / Ctrl.LotesCosechas.length, ""]);
                colors.push('rgba(51, 68, 255, 1)');
                Ctrl.chart(datos, labels, colors, suma); //llamando a la gráfica de cosechas -> llamo a la función que me dibuja la gráfica de cosechas
			});
        };


        Ctrl.chart = (datos, labels, colors, suma) => {
            var ctx = document.getElementById('myChart')?.getContext('2d');
            if(ctx){
                if (myChart) {
                    myChart.destroy(); //se debe destruir la gráfica existente para volver a construir una nueva
                }
                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,   
                        datasets: [{
                            label: "# de cosechas" /*suma + " cosechas en total"*/,
                            data: datos,
                            backgroundColor: colors,
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }


        //INICIO DEV ANGÉLICA
        //Creación de ventana modal para agregar cosechas
        Ctrl.nuevaCosecha = (lote) => {
            /*Ctrl.CosechasCRUD.dialog({
                Flex: 10,
                Title: 'Crear Organización',
                Confirm: { Text: 'Crear Organizacion' },
            }).then(r => {
                if (!r) return;
                Ctrl.CosechasCRUD.add(r);
            });*/
            Rs.BasicDialog({
                Flex: 30,
                Title: "Crear Nueva Cosecha",
                Fields: [
                    {
                        Nombre: "",
                        Value: null,
                        Type: "date",
                        Required: true
                    },
                    {
                        Nombre: "Cantidad",
                        Value: "",
                        Type: "textarea",
                        Required: true
                    },
                    {
                        Nombre: "Kilogramo",
                        Value: "",
                        Type: "textarea",
                        Required: true
                    },
                    {
                        Nombre: "Tipo",
                        Value: null,
                        Type: "simplelist",
                        List: ['Racimo', 'Bulto', 'Canastilla', 'Timbo', 'Bolsa'],
                        Required: true
                    }
                ],
                Confirm: { Text: "Crear Cosecha" }
            }).then(r => {
                if (!r) return;

                const tiempoTranscurrido = Date.now();
                const hoy = new Date(tiempoTranscurrido);
                var NuevaCosecha = {
                    lote_id: lote.id,
                    fecha: hoy.toISOString().slice(0, 10),//r.Fields[0].Value.toISOString().slice(0, 10),
                    cantidad: r.Fields[1].Value,
                    kilogramo: r.Fields[2].Value,
                    tipo: r.Fields[3].Value
                };
                
                Ctrl.CosechasCRUD.add(NuevaCosecha).then(() => {
                    Rs.showToast("Cosecha agregada");                   
                        Ctrl.getLoteCosechas(lote.id, 'x');
                });
            });
        };
        //FIN DEV ANGÉLICA 


        Ctrl.generarSemanas = (fecha_establecimiento, numeroSemanasLote) => {
            let fecha = new Date(fecha_establecimiento);
            let hoy = new Date();

            hoy.setHours(0,0,0,0);

            for(i=1; i < numeroSemanasLote; i++) {
                const f = fecha;

                let fechacontresdiasmas= f.getTime() + (6*24*60*60*1000);  
                let segundaFecha = new Date(fechacontresdiasmas);
                
               
               // if (i >= numeroSemanasLote) {
                    Ctrl.semanas.push({id: i - numeroSemanasLote, fechaInicial: f.toISOString().slice(0, 10), fechaFinal: segundaFecha.toISOString().slice(0, 10), semana: i});
                    if(segundaFecha.getTime() >= hoy.getTime() && f.getTime() <= hoy.getTime()){
                        Ctrl.indice = Ctrl.semanas.length -1;
                    }
                //}

                fecha = new Date(segundaFecha.getTime() + (1*24*60*60*1000));  
            }
        }

        Ctrl.Salir = $mdDialog.cancel;

        Ctrl.LotesCRUD = $injector.get("CRUD").config({
            base_url: "/api/lotes/lotes",
            limit: 1000,
            add_append: "refresh",
            order_by: ["-created_at"],
            query_with:['finca', 'organizacion', 'linea_productiva', 'labor']
        });

        Ctrl.getLotes = () => {
            Ctrl.LotesCRUD.setScope("finca_id", Rs.Usuario.finca_id); //Me trae los lotes de una finca
            Ctrl.LotesCRUD.get().then(() => {
                Ctrl.Lotes = Ctrl.LotesCRUD.rows;
                //Ctrl.editarLote(Ctrl.LotesCRUD.rows[0]);
            });
        };

        Ctrl.getLotes();
        //FIN DEV ANGELICA

        //INICIO DEV ANGÉLICA
        Ctrl.clickOnCard = (lote) => {
            //Las siguientes lineas cierran todos los paneles y deja abierto solo el panel seleccionado
            if(lote.checked){
                lote.checked = false;
            }else{
                Ctrl.Lotes.forEach(L => {
                    L.checked = false;
                });
                lote.checked = true; 
                Ctrl.generarSemanas(lote.fecha_establecimiento, 156);  //este 156 deberia reemplazarse por lote.numeroSemanasLote, esta variable debe almacenar el tiempo que el lote va a ser productivo (tiempo de vida) en esa linea
                Ctrl.getLoteLabores(lote.id, lote.linea_productiva.id, Ctrl.semanas[Ctrl.indice].semana, Ctrl.semanas[Ctrl.indice].fechaInicial, Ctrl.semanas[Ctrl.indice].fechaFinal);
                Ctrl.getLaboresProductor(lote.id, Ctrl.semanas[Ctrl.indice].semana);          
            }
            /* 
            //Estas líneas solo abren o cierran el panel seleccionado, es decir, deja visualizar varios a la vez
            if(!lote.checked){
                lote.checked = true;
            }else{
                lote.checked = !lote.checked;
            }*/
            Ctrl.getLoteCosechas(lote.id, 'fecha');  
        } 
        //FIN DEV ANGELICA

        //INICIO DEV ANGÉLICA

        //O = Orientación de las flechas - si la orientacion es derecha el indice debe incrementarse en 1, si es izq 
        //D = Derecha
        Ctrl.clickOnRow = (O, lote) => {
            if(O === 'D') {
                if(Ctrl.indice < Ctrl.semanas.length-1){
                    Ctrl.indice++;
                    Ctrl.getLoteLabores(lote.id, lote.linea_productiva.id, Ctrl.semanas[Ctrl.indice].semana, Ctrl.semanas[Ctrl.indice].fechaInicial, Ctrl.semanas[Ctrl.indice].fechaFinal);
                    Ctrl.getLaboresProductor(lote.id, Ctrl.semanas[Ctrl.indice].semana);          
                }
            }else{
                if(Ctrl.indice > 0){
                    Ctrl.indice--;
                    Ctrl.getLoteLabores(lote.id, lote.linea_productiva.id, Ctrl.semanas[Ctrl.indice].semana, Ctrl.semanas[Ctrl.indice].fechaInicial, Ctrl.semanas[Ctrl.indice].fechaFinal);
                    Ctrl.getLaboresProductor(lote.id, Ctrl.semanas[Ctrl.indice].semana);          
                }
            }
        }
        //FIN DEV ANGELICA


        //INICIO DEV ANGÉLICA ------> para hacer el evento del checkbox y que guarde en BD en la tabla lote_labores_realizadas
        Ctrl.LoteLaboresRealizadasCRUD = $injector.get("CRUD").config({
            base_url: "/api/lotelaboresrealizadas/lotelaboresrealizadas",
            limit: 1000,
            add_append: "refresh",
        });

        Ctrl.guardarLaborRealizada = (lote, labor_id, delta) => {
            console.log(labor_id);
            Ctrl.LoteLaboresRealizadasCRUD.add({
                lote_id: lote.id,
                labor_id: labor_id,
                cumplimiento: delta===0?1:0.5, 
                fecha: (new Date()).toISOString().slice(0, 10) //slice es para hacer formato a la fecha y coger solo los 10 primeros
            });
        }
        //FIN DEV ANGÉLICA

        //INICIO DEV ANGÉLICA 
        Ctrl.nuevoLoteLabor = () => {
            Ctrl.LoteLaboresCRUD.dialog({
                Flex: 10,
                Title: "Agregar Labor",

                Confirm: { Text: "Agregar Labor" }
            }).then(r => {
                if (!r) return;
                Ctrl.LoteLaboresCRUD.add(r);
                Rs.showToast('Labor Agregada');
            });
        };    
        //FIN DEV ANGÉLICA 


        //INICIO DEV ANGÉLICA ------> para hacer el modal agregar labor eventual de productor 
        Ctrl.nuevaLaborProductor = (lote, semana_id) => {
            Rs.BasicDialog({
                Flex: 10,
                Title: "Agregar Labor",
                Fields: [
                    {
                        Nombre: "Agregue su labor de hoy",
                        Value: "",
                        Type: "textarea",
                        Required: true
                    },
                ],
                Confirm: { Text: "Agregar Labor" }
            }).then(r => {
                if (!r) return;
        
                var NuevaLaborProductor = {
                    lote_id: lote.id,
                    labor: r.Fields[0].Value,
                    semana_id,
                    fecha: new Date()
                };
                
                Ctrl.LoteLaboresProductorCRUD.add(NuevaLaborProductor).then(() => {
                    Rs.showToast("Labor de hoy agregada"); 
                    Ctrl.LaboresProductor.push({"labor":r.Fields[0].Value}); //Agrega una labor productor en la lista que estpa en memoria                  
                });
            });
        };    
        //FIN DEV ANGÉLICA 


        Ctrl.editarLoteLabor = LB => {
            Ctrl.LoteLaboresCRUD.dialog(LB, {
                title: "Editar Evento" + LB.id
            }).then(r => {
                if (r == "DELETE") return Ctrl.LoteLaboresCRUD.delete(LB);
                Ctrl.LoteLaboresCRUD.update(r).then(() => {
                    Rs.showToast("Evento actualizado");
                });
            });
        };

        Ctrl.eliminarLoteLabor = LB => {
            Rs.confirmDelete({
                Title: "¿Eliminar Lote #" + LB.id + "?"
            }).then(d => {
                if (!d) return;
                Ctrl.LoteLaboresCRUD.delete(LB);
            });
        };
        // FIN
          
    }
]);
