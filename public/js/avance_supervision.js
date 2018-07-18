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
                //"http://localhost/raton_app/api/web/avance_supervision.php"
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