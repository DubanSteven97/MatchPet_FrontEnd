<?php 
if($data['grafica'] == "donacionesMes"){
 ?>
<script>
	Highcharts.chart('graficaMes', {
	    chart: {
	        type: 'spline'
	    },
	    title: {
	        text: 'Donaciones de <?=$data['mes']?> del <?=$data['anio']?>'
	    },
	    subtitle: {
	        text: 'Tolal Donaciones: <?= FormatMoney($data['total'])?>'
	    },
	    xAxis: {
	        categories: [<?php 
	            foreach ($data['donacion'] as $dia) {
	               echo $dia['dia'].',';
	             } 
	          ?>],
	        accessibility: {
	            description: 'Días del mes de <?=$data['mes']?>'
	        }
	    },
	    yAxis: {
	        title: {
	            text: 'Total'
	        },
	        labels: {
	            formatter: function () {
	                return this.value;
	            }
	        }
	    },
	    tooltip: {
	        crosshairs: true,
	        shared: true
	    },
	    plotOptions: {
	        spline: {
	            marker: {
	                radius: 4,
	                lineColor: '#666666',
	                lineWidth: 1
	            }
	        }
	    },
	    series: [{
	        name: '',
	        data: [<?php 
	            foreach ($data['donacion'] as $dia) {
	               echo $dia['total'].',';
	             } 
	          ?>]

	    }]
	});
</script>
<?php } ?>


<?php 
if($data['grafica'] == "ventasAnio"){
 ?>
<script>
	Highcharts.chart('graficaAnio', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'Ventas del año <?=$data['anio']?> '
	    },
	    subtitle: {
	        text: 'Estadística de ventas por mes'
	    },
	    xAxis: {
	        type: 'category',
	        labels: {
	            rotation: -45,
	            style: {
	                fontSize: '13px',
	                fontFamily: 'Verdana, sans-serif'
	            }
	        }
	    },
	    yAxis: {
	        min: 0,
	        title: {
	            text: ''
	        }
	    },
	    legend: {
	        enabled: false
	    },
	    tooltip: {
	        pointFormat: 'Ventas en <?=$data['anio']?>: <b>{point.y:.1f}</b>'
	    },
	    series: [{
	        name: 'Ventas',
	        data: [
	        <?php 
	          foreach ($data['meses'] as $mes) {
	            echo "['".$mes['mes']."', ".$mes['venta']."],";
	          }

	         ?>
	            
	        ],
	        dataLabels: {
	            enabled: true,
	            rotation: -90,
	            color: '#FFFFFF',
	            align: 'right',
	            format: '{point.y:.1f}', // one decimal
	            y: 10, // 10 pixels down from the top
	            style: {
	                fontSize: '13px',
	                fontFamily: 'Verdana, sans-serif'
	            }
	        }
	    }]
	});
</script>
<?php } ?>