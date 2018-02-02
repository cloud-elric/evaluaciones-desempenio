<?php

use yii\web\View;
use yii\helpers\Url;
$this->title="Reporte por competencias";

$this->params['classBody'] = "site-navbar-small dashboard-admin";

$this->registerCssFile(
  '@web/webAssets/css/admin/index.css',
  ['depends' => [\app\assets\AppAsset::className()]]
);


$this->registerJsFile(
    '@web/webAssets/templates/classic/global/vendor/chart-js/Chart.js',
    ['depends' => [\app\assets\AppAsset::className()]]
  );
  
  $this->registerJsFile(
    'https://unpkg.com/jspdf@latest/dist/jspdf.min.js',
    ['depends' => [\app\assets\AppAsset::className()]]
  );
  
  $this->registerJsFile(
    '@web/webAssets/plugins/html2canvas/html2canvas.js',
    ['depends' => [\app\assets\AppAsset::className()]]
  );
  
  $this->registerJsFile(
    '@web/webAssets/js/admin/reportes.js',
    ['depends' => [\app\assets\AppAsset::className()]]
  );
  
  $this->registerCssFile(
    '@web/webAssets/templates/classic/topbar/assets/examples/css/charts/chartjs.css',
    ['depends' => [\app\assets\AppAsset::className()]]
  );
?>
<div class="page">
    <!-- Media Content -->
    <div class="page-main">
        <!-- Media Content Header -->
        <div class="page-header">
            <h1 class="page-title"><?=$this->title?></h1>  
        </div>
        <div id="mediaContent" class="page-content page-content-table">
            <div class="col-md-12">
                <div class="example-wrap">
                    <div class="panel">
                        <div class="panel-body">
                            
                            <div id="contenedor">
                                
                                <?php
                                foreach($resultados as $cuestionario){
                                ?>
                                 
                                <div class="panel">
                                    <div class="panel-body">
                                    <br>
                                        <button class="btn btn-primary float-right ladda-button" data-style="zoom-in" id="exportar-<?=$cuestionario["identificador"]?>">
                                            <span class="ladda-label">
                                                <i class="icon oi-file-pdf" aria-hidden="true"></i>
                                                Exportar
                                            </span>
                                        </button>
                                        <section id="container-export-<?=$cuestionario["identificador"]?>">
                                            <h6 class="panel-title">
                                                <small>
                                                    Número de encuestados totales:<?=$cuestionario["numeroEncuestados"]?>
                                                </small><br>
                                                <?=$cuestionario["nombre_cuestionario"]?><br>
                                                <small>
                                                <?=round($cuestionario["promedioTotal"], 1)?>
                                                </small>
                                            </h6>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                $preguntaT = '';
                                                $index = 0;
                                                $preguntaV = '';
                                                
                                                foreach($cuestionario['preguntas'] as $keys=>$pregunta){

                                                if ($pregunta === end($cuestionario['preguntas'])) {
                                                    $preguntaT .= '"Pregunta '.++$index.'"';
                                                    $preguntaV .= $pregunta['promedio']."";
                                                    
                                                }else{
                                                    $preguntaT .= '"Pregunta '.++$index.'",';
                                                    $preguntaV .= $pregunta['promedio'].",";
                                                
                                                }
                                                
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p>
                                                        <span class="badge badge-outline badge-success">Pregunta <?=$index?></span>
                                                        <br>  
                                                        <?=$pregunta["texto_pregunta"]?>
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <canvas id="chart<?=$cuestionario["identificador"]?>">

                                                </canvas>

                                                <?php 
                                                $this->registerJs(
                                                    '
                                                    $(document).ready(function(){
                                                        $("#exportar-'.$cuestionario["identificador"].'").on("click",  function(){
                                                          var l = Ladda.create(this);
                          
                                                          var nombreArchivo = "Reporte nivel '.$cuestionario['nombre_cuestionario'].'";
                                                            descargarReportePDF("#container-export-'.$cuestionario["identificador"].'", l, nombreArchivo);
                                                            
                                                        });
                          
                                                    });
                                                    var index = 0;
                                                    var ctx'.$cuestionario["identificador"].' = $("#chart'.$cuestionario["identificador"].'");
                                                    var myChart = new Chart(ctx'.$cuestionario["identificador"].', {
                                                        type: "bar",
                                                        data: {
                                                            labels: ['.$preguntaT.'],
                                                            datasets: [{
                                                                type: "bar",
                                                                label: "Total otros",
                                                                data: ['.$preguntaV.'],
                                                                backgroundColor: colorInicial,
                                                                borderWidth: 1
                                                            },
                                                            
                                                            ]
                                                        },
                                                        options: optionsGrafica
                                                    });
                                                    ',
                                                    View::POS_READY,
                                                    $cuestionario["identificador"]
                                                );
                                                ?>
                                               
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <?php
                                }

                                ?>
                            </div>
                            <div class="contenedor-iframe">
                                <iframe id='iframe' style='display:none;'></iframe>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
