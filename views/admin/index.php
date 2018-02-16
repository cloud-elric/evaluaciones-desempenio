<?php

use yii\web\View;
use yii\helpers\Url;
$this->title="Reporte por nivel";

$this->params['classBody'] = "site-navbar-small dashboard-admin";

$this->registerJsFile(
    '@web/webAssets/js/admin/index.js',
    ['depends' => [\app\assets\AppAssetClassicTopBar::className()]]
);

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
    <div class="page-header-actions">
      
        <!-- <button class="btn btn-success float-right ladda-button" id="js-enviar-email" data-style="zoom-in">
            <span class="ladda-label">
                Enviar evaluaciones
                <i class="icon fa-send" aria-hidden="true"></i>
            </span>
            
        </button> -->
        
    </div>
  </div>
  <!-- Media Content -->
  <div id="mediaContent" class="page-content page-content-table">
  <div class="col-md-12">
  <div class="example-wrap">
    <div class="nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
      <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
        <?php
        $active = true;
        foreach($resultados as $idArea=>$resultado){
        ?>
        <li class="nav-item" role="presentation">
          <a class="nav-link <?=$active?'active':''?>" data-toggle="tab" href="#nivel-<?=$idArea?>"
           role="tab" aria-expanded="true">
          Nivel <?=$resultado['nombre_nivel']?>
          </a>
        </li>

        <?php
        $active = false;
        }
        ?>

      </ul>
      <div class="tab-content">

      <?php
        $active = true;
        foreach($resultados as $idArea=>$resultado){
        ?>

        <div class="tab-pane <?=$active?'active':''?> animation-slide-left" id="nivel-<?=$idArea?>"
        role="tabpanel">
        
        <div class="contenedor-<?=$idArea?>" id="contenedor-<?=$idArea?>">
            <?php
            foreach($resultado["cuestionarios"] as $cuestionario){
            ?>  

            <div class="panel">
              <div class="panel-body">
              <button class="btn btn-primary float-right ladda-button" data-style="zoom-in" id="exportar-<?=$cuestionario["identificador"]?>">
                <span class="ladda-label">
                  <i class="icon oi-file-pdf" aria-hidden="true"></i>
                  Exportar
                  </span>
                </button>
                <section id="container-export-<?=$cuestionario["identificador"]?>">
                  <h6 class="panel-title">
                    <small>
                    Número de encuestados totales: <?=$cuestionario["numEncuestados"]?>
                    </small><br>
                    Nivel <?=$resultado['nombre_nivel']?> - <?=$cuestionario["nombre_cuestionario"]?><br>
                    <small>
                    <?=$cuestionario["promedioCuestionario"]?>
                    </small>
                  </h6>
                  <div class="row">
                    <div class="col-md-3">
                      <?php
                      $preguntaT = '';
                      $index = 0;
                      $preguntaV = '';
                      $minimo = '';
                      foreach($cuestionario['preguntas'] as $keys=>$pregunta){

                        if ($pregunta === end($cuestionario['preguntas'])) {
                          $preguntaT .= '"Pregunta '.++$index.'"';
                          $preguntaV .= $pregunta['promedio']."";
                          $minimo .= $cuestionario["puntuacionPromedio"]."";
                        }else{
                          $preguntaT .= '"Pregunta '.++$index.'",';
                          $preguntaV .= $pregunta['promedio'].",";
                          $minimo .= $cuestionario["puntuacionPromedio"].",";
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
                  
                    <div class="col-md-9">
                      <canvas id="chart<?=$cuestionario["identificador"]?>">

                      </canvas>

                      <?php
                      
                      $this->registerJs(
                          '
                          $(document).ready(function(){
                              $("#exportar-'.$cuestionario["identificador"].'").on("click",  function(){
                                var l = Ladda.create(this);

                                var nombreArchivo = "Reporte nivel '.$resultado['nombre_nivel'].' - '.$cuestionario["nombre_cuestionario"].'";
                                  descargarReportePDF("#container-export-2-'.$cuestionario["identificador"].'", l, nombreArchivo);
                                  
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
                                      //backgroundColor: colors[index++],
                                      borderWidth: 1
                                  },
                                  {
                                      fill:false,
                                      type: "line",
                                      label: "Nivel meta",
                                      data: ['.$minimo.'],
                                      showLine:true,
                                      borderWidth: 1,
                                      backgroundColor: "#FBC02D",
                                  }
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
        </div>
        <div class="contenedor-iframe">
          <iframe id='iframe<?=$idArea?>' style='display:none;'></iframe>
        </div>  
        <?php
        $active = false;

        

        }
        ?>
        
      </div>
    </div>
  </div>
</div>
  </div>
</div>
</div>


<div style="display:block; position:absolute; top:-100000000px">
<?php
        $active = true;
        foreach($resultados as $idArea=>$resultado){
        ?>
        
        <div class="row">
            <?php
            foreach($resultado["cuestionarios"] as $cuestionario){
            ?>  

            <div class="panel">
              <div class="panel-body">
              
                <section id="container-export-2-<?=$cuestionario["identificador"]?>">
                <br><br><br>
                  <h6 class="panel-title" style="margin-top:30px;">
                    <small>
                    Número de encuestados totales: <?=$cuestionario["numEncuestados"]?>
                    </small><br>
                    Nivel <?=$resultado['nombre_nivel']?> - <?=$cuestionario["nombre_cuestionario"]?><br>
                    <small>
                    <?=$cuestionario["promedioCuestionario"]?>
                    </small>
                  </h6>
                  <div class="row">
                    <div class="col-md-3">
                      <?php
                      $preguntaT = '';
                      $index = 0;
                      $preguntaV = '';
                      $minimo = '';
                      foreach($cuestionario['preguntas'] as $keys=>$pregunta){

                        if ($pregunta === end($cuestionario['preguntas'])) {
                          $preguntaT .= '"Pregunta '.++$index.'"';
                          $preguntaV .= $pregunta['promedio']."";
                          $minimo .= $cuestionario["puntuacionPromedio"]."";
                        }else{
                          $preguntaT .= '"Pregunta '.++$index.'",';
                          $preguntaV .= $pregunta['promedio'].",";
                          $minimo .= $cuestionario["puntuacionPromedio"].",";
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
                  
                    <div class="col-md-9">
                      <canvas id="chart-2-<?=$cuestionario["identificador"]?>">

                      </canvas>

                      <?php
                      
                      $this->registerJs(
                          '
                          
                          var index = 0;
                          var ctx'.$cuestionario["identificador"].' = $("#chart-2-'.$cuestionario["identificador"].'");
                          var myChart = new Chart(ctx'.$cuestionario["identificador"].', {
                              type: "bar",
                              data: {
                                  labels: ['.$preguntaT.'],
                                  datasets: [{
                                      type: "bar",
                                      label: "Total otros",
                                      data: ['.$preguntaV.'],
                                      //backgroundColor: colors[index++],
                                      borderWidth: 1
                                  },
                                  {
                                      fill:false,
                                      type: "line",
                                      label: "Nivel meta",
                                      data: ['.$minimo.'],
                                      showLine:true,
                                      borderWidth: 1,
                                      backgroundColor: "#FBC02D",
                                  }
                                  ]
                              },
                              options: optionsGrafica
                          });
                          ',
                          View::POS_READY,
                          $cuestionario["identificador"]."v2"
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
        
         
        <?php
        $active = false;

        

        }
        ?>
</div>