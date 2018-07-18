<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">	
<title>Control de Roedores</title>
    <!--script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.0/dist/Chart.min.js"></script-->
    <script src="{{ URL::to('/js/Chart.min.js') }}"></script>   
    <!--script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script-->
              <script src="{{ URL::to('/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ URL::to('js/datalabels.js') }}"></script>

    <!--link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"-->
    <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script-->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/css/bootstrap.min.css') }}">
    <script src="{{ URL::to('/js/bootstrap.min.js') }}"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/css/style.css') }}">
</head>
<body style="background-color: #f1f1f1">
    <div class="text-center centered-vertical information"><h1><strong>Programa de Control de Roedores</strong></h1>
    Elementos totales <p class="inline" id="cantidad"> </p>- supervisados <p class="inline" id="supervisados"></p><br>Fecha : <p class="inline" id="fecha"></p><a class="btn btn-success" style="margin-left: 2vw" href="{{ URL::to('/excel') }}">Descargar Excel</a></div>
<div class="row centered">
<div class="col-4 card" style="transform: translate(-50%, 0%);">
<canvas  id="grafico_avance" class="r-card" width="300" height="450" ></canvas>
     </div>
        <script type="text/javascript">
           
            var cantidad = document.getElementById("cantidad");
        	var supervisados = document.getElementById("supervisados");
            var fecha = document.getElementById('fecha');
            var dia = new Date();
  function spanishDate(d){
var weekday=["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"];
var monthname=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
return weekday[d.getDay()]+" "+d.getDate()+" de "+monthname[d.getMonth()]+" de "+d.getFullYear()
}
            fecha.innerHTML = spanishDate(dia);
            var avance;
        	
        	$.ajax({
                url: "{{URL::to('/home/avance')}}",
        		dataType : "JSON"
       	})
        	.done(function(data){
	console.log(data["avance"]);
	var total = 1000;                
cantidad.innerHTML = total;
                supervisados.innerHTML = data["avance"];
        		avance = (data["avance"] / total) * 100 ;
                var pendiente = ((total - data["avance"]) / total ) * 100;
                avance = +avance.toFixed(2);
                pendiente = +pendiente.toFixed(2);
            var gph_avance = document.getElementById("grafico_avance").getContext("2d");
            var grafico = new Chart(gph_avance, {
                type : 'pie',
                data : {
                    labels : ["Supervisado", "No supervisado"],
                    datasets : [{
                        data : [avance, pendiente],
                        backgroundColor : [
                            'rgba(47,181,243, 0.2)',
                            'rgba(106,37,158, 0.2)'
                        ],
                        borderColor : [
                        'rgba(47,181,243, 0.2)',
                            'rgba(106,37,158, 0.2)'                    
                        ],
                        borderWidth : 1
                    }]
                },
                options: {
                plugins: {
                    datalabels: {
                        backgroundColor: function(context) {
                            return context.dataset.backgroundColor;
                        },
                        borderColor: 'black',
                        borderRadius: 25,
                        borderWidth: 2,
                        color: 'black',
                        display: function(context) {
                            var dataset = context.dataset;
                            var count = dataset.data.length;
                            var value = dataset.data[context.dataIndex];
                            return value > count * 1.5;
                        },
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                    responsive : true,
                    title: {
                        display: true,
                        position: "top",
                        text: "Avance de supervisión (%)",
                        fontSize: 22,
                        fontColor: "#111"
                     }
                }
            });
        });
        
    </script>
<div class="col-4 card"  >
<canvas  id="grafico_captura" class="r-card" width="300" height="450"></canvas>
     </div>
        <script type="text/javascript">
            var si;
            var total;
            $.ajax({
                url: "{{URL::to('/home/captura')}}",
              //  url:"../api/web/avance_captura.php",
                dataType : "JSON"
            })
            .done(function(data){
                total = data["TOTAL"];
                si = (data["SI"] / total) * 100 ;
                var no = (data["NO"]/total)*100;
                si = +si.toFixed(2);
                no = +no.toFixed(2);
                console.log("SI "+si);
                console.log("NO "+no);
            var gph_captura = document.getElementById("grafico_captura").getContext("2d");
            var grafico = new Chart(gph_captura, {
                type : 'pie',
                data : {
                    labels : ["Captura", "No captura"],
                    datasets : [{
                        data : [si, no],
                        backgroundColor : [
                            'rgba(47,181,243, 0.2)',
                            'rgba(106,37,158, 0.2)'
                        ],
                        borderColor : [
                        'rgba(47,181,243, 0.2)',
                        'rgba(106,37,158, 0.2)'                  
                        ],
                        borderWidth : 1
                    }]
                },
                options: {
                    plugins: {
                    datalabels: {
                        backgroundColor: function(context) {
                            return context.dataset.backgroundColor;
                        },
                        borderColor: 'black',
                        borderRadius: 25,
                        borderWidth: 2,
                        color: 'black',
                        display: function(context) {
                            var dataset = context.dataset;
                            var count = dataset.data.length;
                            var value = dataset.data[context.dataIndex];
                            return value > count * 1.5;
                        },
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                    responsive : true,
                    title: {
                        display: true,
                        position: "top",
                        text: "Capturas (%)",
                        fontSize: 22,
                        fontColor: "#111"
                     }
                }
            });
            
        });
        
    </script>
<div class="col-4 card"  style="transform: translate(50%, 0%);">
<canvas  id="grafico_estado" class="r-card" width="300" height="450"></canvas>
     </div>
        <script type="text/javascript">
            $.ajax({
                url: "{{URL::to('/home/estado')}}",
                dataType : "JSON"
            })
            .done(function(data){
                let sin_acceso = data[0]["TOT_SIN_ACCESO"];
                let retirado = data[0]["TOT_RETIRADO_CLIENTE"];
                let operativo = data[0]["TOT_OPERATIVO"];
                let perdido = data[0]["TOT_PERDIDO"];
                let danado = data[0]["TOT_DANADO"];
                let sustituido = data[0]["TOT_SUSTITUIDO"];
            var gph_estado = document.getElementById("grafico_estado").getContext("2d");
            var grafico = new Chart(gph_estado, {
                type : 'bar',
                data : {
                    labels : ["Operativo", "Retirado","Perdido","Dañado","Sustituido","Sin acceso"],
                    datasets : [{
                        data : [operativo, retirado, perdido, danado, sustituido, sin_acceso],  
                        backgroundColor : [
                            'rgba(77,238,234, 0.2)',
                            'rgba(116,238,21, 0.2)',
                            'rgba(255,231,0, 0.2)',
                            'rgba(240,0,255, 0.2)',
                            'rgba(0,30,255, 0.2)',
                            'rgba(106,37,158, 0.2)'
                        ],
                        borderColor : [
                            'rgba(77,238,234, 0.2)',
                            'rgba(116,238,21, 0.2)',
                            'rgba(255,231,0, 0.2)',
                            'rgba(240,0,255, 0.2)',
                            'rgba(0,30,255, 0.2)',
                            'rgba(106,37,158, 0.2)'
                        ],
                        borderWidth : 1
                    }]
                },
                options: {
                    legend: {
                        display: false
                        },
                    tooltips: {
                        enabled: false
                        },
                    plugins: {
                    datalabels: {
                        color: 'black',
                        display: function(context) {
                            return context.dataset.data[context.dataIndex] > 15;
                        },
                        font: {
                            weight: 'bold'
                        },
                        formatter: Math.round
                    }
                },
                scales: {
                    xAxes: [{
                        ticks : {
                            fontSize : 10
                        },
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                },
                    responsive : true,
                    title: {
                        display: true,
                        position: "top",
                        text: "Estado de dispositivos",
                        fontSize: 22,
                        fontColor: "#111"
                     }
                }
            });
            
        });

            function getExcel(){
                $.ajax({
                    url: "{{ URL::to('/excel') }}"
                });
            }
        
    </script>
</div>
<div class="down text-center">
    <div style="margin-left: 20vw; margin-top: 1vh;">
    <h5 style="margin-right: 20vw;"><strong>Desarrollado por Bruno León - Full Stack Android & Web Developer</strong></h3>
       <div style="bottom: 0; position: fixed; right: :50;"><ul style="display: inline;">
        <li><a target="_blank" href="https://stackoverflow.com/users/7847035/b-le%c3%b3n"><i class="fab fa-stack-overflow"></i> Stack Overflow</a></li>
        <li><a target="_blank" href="https://www.linkedin.com/in/bruno-le%C3%B3n-925112141/"><i class="fab fa-linkedin-in"></i> Linkedin</a></li>
        <li><a target="_blank" href="https://github.com/nosavvy33"><i class="fab fa-github"></i> GitHub</a></li>
    </ul></div>
    </div>
</div>
</body>
</html>