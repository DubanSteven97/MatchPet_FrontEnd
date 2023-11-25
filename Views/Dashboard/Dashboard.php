<?php HeaderAdmin($data); ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> <?= $data['page_title'];?></h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="<?=BaseUrl();?>/dashboard"><?= $data['page_title'];?></a></li>
      </ul>
    </div>
    <div class="row">
      
      <?php if(!empty($_SESSION['permisos']['Usuarios']['r'])){ ?>
        <div class="col-md-6 col-lg-3">
          <a href="<?=BaseUrl();?>/usuarios" class="linkw">
            <div class="widget-small primary coloured-icon"><i class="<?=$_SESSION['permisos']['Usuarios']['icono']?>"></i>
              <div class="info">
                <h4><?=$_SESSION['permisos']['Usuarios']['modulo']?></h4>
                <p><b><?=$data['usuarios'];?></b></p>
              </div>
            </div>
          </a>
        </div>
      <?php } ?>
      <?php if(!empty($_SESSION['permisos']['Clientes']['r'])){ ?>
        <div class="col-md-6 col-lg-3">
          <a href="<?=BaseUrl();?>/clientes" class="linkw">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-user fa-3x"></i>
              <div class="info">
                <h4>Clientes</h4>
                <p><b><?=$data['clientes'];?></b></p>
              </div>
            </div>
          </a>
        </div>
      <?php } ?>
      <?php if(!empty($_SESSION['permisos']['Animales']['r'])){ ?>
        <div class="col-md-6 col-lg-3">
          <a href="<?=BaseUrl();?>/Animales" class="linkw">
            <div class="widget-small warning coloured-icon"><i class="<?=$_SESSION['permisos']['Animales']['icono']?>"></i>
              <div class="info">
                <h4><?=$_SESSION['permisos']['Animales']['modulo']?></h4>
                <p><b><?=$data['animales'];?></b></p>
              </div>
            </div>
          </a>
        </div>
      <?php } ?>
      <?php if(!empty($_SESSION['permisos']['Organizaciones']['r'])){ ?>
        <div class="col-md-6 col-lg-4">
          <a href="<?=BaseUrl();?>/Organizaciones" class="linkw">
            <div class="widget-small danger coloured-icon"><i class="<?=$_SESSION['permisos']['Organizaciones']['icono']?>"></i>
              <div class="info">
                <h4><?=$_SESSION['permisos']['Organizaciones']['modulo']?></h4>
                <p><b><?=$data['organizaciones'];?></b></p>
              </div>
            </div>
          </a>
        </div>
        <?php } ?>
      </div>
      </div>

        <div class="row">
          <?php if(!empty($_SESSION['permisos']['Donaciones']['r'])){ ?>
          <div class="col-md-6">
            <div class="tile">
              <h3 class="tile-title">Últimas donaciones</h3>
              <table class="table table-striped table-sm">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Amigo</th>
                    <th>Organización</th>
                    <th>Estado</th>
                    <th class="text-right">Monto</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(count($data['lastDonaciones'])>0){ 
                    foreach ($data['lastDonaciones'] as $donacion) {
                    ?>
                  <tr>
                    <td><?= $donacion['idDonacion'];?></td>
                    <td><?= $donacion['nombre'];?></td>
                    <td><?= $donacion['Organizacion'];?></td>
                    <td><?= $donacion['estado'];?></td>
                    <td class="text-right"><?= FormatMoney($donacion['monto']);?></td>
                  </tr>
                <?php }
                    } ?>

                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
<?php if($_SESSION['userData']['nombreRol'] != "Amigo"){ ?>    
            <div class="col-md-6">
                <div class="tile">
                  <div class="container-title">
                    <h3 class="tile-title">Adopciones</h3>
                  </div>
                  <div id="estadoAdopciones"></div>
                </div>
            </div>
            
        </div>
      
        <div class="row">
          <div class="col-md-12">
            <div class="tile">
              <div class="container-title">
                <h3 class="tile-title">Donaciones por mes</h3>
                <div class="dflex">
                  <input class="date-picker donacionesMes" name="donacionesMes" placeholder="Mes y Año"></input>
                  <button type="button" class="btnDonacionesMes btn btn-info btn-sm" onclick="fntSearchDonacionesMes()"><i class="fas fa-search"></i></button>
                </div> 
              </div>
              <div id="graficaMes"></div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="tile">
              <div class="container-title">
                <h3 class="tile-title">Donaciones por año</h3>
                <div class="dflex">
                  <input class="ventasAnio" name="ventasAnio" placeholder="Año" minlength="4" maxlength="4" onkeypress="return ControlTag(event);"></input>
                  <button type="button" class="btnVentasAnio btn btn-info btn-sm" onclick="fntSearchPagosAnio()"><i class="fas fa-search"></i></button>
                </div> 
              </div>
              <div id="graficaAnio"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="tile">
              <div class="container-title">
                <h3 class="tile-title">Adopciones por mes - Año <?php echo date('Y'); ?></h3>
              </div>
              <div id="graficaAdopcionesMes"></div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="tile">
              <div class="container-title">
                <h3 class="tile-title">Adopciones por año</h3>
                <div id="graficaAdopcionesAnio"></div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>


  </main>
<?php FooterAdmin($data); ?>   

<script type="text/javascript">

function generateOrangePalette(steps) {
    const baseColor = [255, 165, 0]; // Color base naranja
    const stepSize = 20; // Tamaño del paso para el degradado

    const colorPalette = Array.from({ length: steps }, (_, index) => {
        const factor = 1 - index / (steps - 1);
        return [
            Math.round(baseColor[0] * factor),
            Math.round(baseColor[1] * factor),
            Math.round(baseColor[2] * factor)
        ];
    });

    return colorPalette.map(color => `rgb(${color.join(',')})`);
}


//donaciones
Highcharts.chart('graficaMes', {
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Donaciones de <?=$data['donacionesMDia']['mes']?> del <?=$data['donacionesMDia']['anio']?>'
    },
    subtitle: {
        text: 'Tolal Donaciones: <?= FormatMoney($data['donacionesMDia']['total'])?>'
    },
    xAxis: {
        categories: [<?php 
            foreach ($data['donacionesMDia']['donacion'] as $dia) {
               echo $dia['dia'].',';
             } 
          ?>],
        accessibility: {
            description: 'Días del mes de <?=$data['donacionesMDia']['mes']?>'
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
            foreach ($data['donacionesMDia']['donacion'] as $dia) {
               echo $dia['total'].',';
             } 
          ?>]

    }]
});


Highcharts.chart('graficaAnio', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Donaciones del año <?=$data['donacionesAnio']['anio']?> '
    },
    subtitle: {
        text: 'Estadística de donaciones por mes'
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
        pointFormat: 'Donaciones en <?=$data['donacionesAnio']['anio']?>: <b>{point.y:.1f}</b>'
    },
    series: [{
        name: 'Donaciones',
        data: [
        <?php 
          foreach ($data['donacionesAnio']['meses'] as $mes) {
            echo "['".$mes['mes']."', ".$mes['donacion']."],";
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

// Número de pasos o tonos en la paleta
const numberOfSteps = 10;
  // Data retrieved from https://netmarketshare.com
Highcharts.chart('estadoAdopciones', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Estados de las adopciones, <?=$data['adopcionesMes']['mes']?> <?=$data['adopcionesMes']['anio']?>'
    },
    tooltip: {
        pointFormat: '<b>{point.y}</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}'
            }
        }
    },
    colors: generateOrangePalette(numberOfSteps),
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
        <?php 
          foreach ($data['adopcionesMes']['adopciones'] as $pagos) {
            echo "{name:'".$pagos['nombre_estado']."', y:".$pagos['adopcion']."},";
          }

         ?>
        ],
        
    }]
});


Highcharts.chart('graficaAdopcionesMes', {
  chart: {
        type: 'column'
    },
    title: {
        text: 'Adopciones aprobadas por mes'
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
            text: 'Cantidad'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Cantidad: <b>{point.y:.1f} unidades</b>'
    },
    series: [{
        name: 'Population',
        data: [
        <?php 
          foreach ($data['adopcionesPorMes']['adopcionesPorMes'] as $pagos) {
            echo "['".$pagos['mes']."',".$pagos['adopcion']."],";
          }

         ?>
        ],
        color: 'orange', 
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

Highcharts.chart('graficaAdopcionesAnio', {
  chart: {
        type: 'column'
    },
    title: {
        text: 'Adopciones aprobadas por año'
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
            text: 'Cantidad'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Cantidad: <b>{point.y:.1f} unidades</b>'
    },
    series: [{
        name: 'Population',
        data: [
        <?php 
          foreach ($data['adopcionesPorAno']['adopcionesPorAno'] as $pagos) {
            echo "['".$pagos['ano']."',".$pagos['adopcion']."],";
          }

         ?>
        ],
        color: 'peru', 
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