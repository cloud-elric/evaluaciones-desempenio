<?php

use yii\web\View;
$this->title="Reporte por nivel";

$this->params['classBody'] = "site-navbar-small dashboard-admin";

$this->registerJsFile(
    '@web/webAssets/js/admin/index.js',
    ['depends' => [\app\assets\AppAssetClassicTopBar::className()]]
);


$this->registerJsFile(
  '@web/webAssets/templates/classic/global/vendor/d3/d3.min.js',
  ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
  '@web/webAssets/templates/classic/global/vendor/c3/c3.min.js',
  ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
  '@web/webAssets/plugins/jspdf/jspdf.js',
  ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerCssFile(
  '@web/webAssets/css/admin/index.css',
  ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerCssFile(
  '@web/webAssets/templates/classic/global/vendor/c3/c3.css',
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
      
        <button class="btn btn-success float-right ladda-button" id="js-enviar-email" data-style="zoom-in">
            <span class="ladda-label">
                Enviar evaluaciones
                <i class="icon fa-send" aria-hidden="true"></i>
            </span>
            
        </button>
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
        <div class="panel">
          <div class="panel-body">
            <button class="btn btn-primary float-right" id="exportar-<?=$idArea?>">
              <i class="icon oi-file-pdf" aria-hidden="true"></i>
              Exportar
            </button>
          </div>
        </div>
        <div class="contenedor-<?=$idArea?>">
            <?php
            foreach($resultado["cuestionarios"] as $cuestionario){
            ?>  
            <div class="panel">
              <div class="panel-body">

                <section>
                  <h6 class="panel-title">
                    <?=$cuestionario["nombre_cuestionario"]?><br>
                    <small>
                    <?=$cuestionario["promedioCuestionario"]?>
                    </small>
                  </h6>
                  <div class="row">
                    <div class="col-md-6">
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
                  
                    <div class="col-md-6">
                      <div id="chart<?=$cuestionario["identificador"]?>">

                      </div>

                      <?php
                      $this->registerJs(
                        "var simple_line_chart".$cuestionario["identificador"]." = c3.generate({
                          bindto: '#chart".$cuestionario["identificador"]."',
                          data: {
                            x: 'x',
                            columns: [
                              ['x', ".$preguntaT."],
                              ['puntuacion', ".$preguntaV."],
                              ['data1', ".$minimo." ]
                            ],
                            names: {
                              puntuacion: 'Total otros',
                              data1: 'Nivel meta',
                            },
                            colors: {
                              data1: 'rgb(255, 233, 0)',
                            },
                            type:'bar',
                            types: {
                              data1: 'line',
                          },
                          },
                          color: {
                            pattern: [Config.colors('primary', 600), Config.colors('green', 600)]
                          },
                          axis: {
                            x: {
                                type: 'category',
                                tick: {
                                    //rotate: 75,
                                    multiline: false
                                },
                              
                            },
                            y: {
                              max: 5,
                              min: 0,
                              tick: {
                                outer: false,
                                count: 5,
                                values: [0, 1, 2, 3, 4, 5]
                              }
                            }
                          },
                          grid: {
                            x: {
                              show: false
                            },
                            y: {
                              show: true
                            }
                          }
                        });",
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

        <?php
        $active = false;

        $this->registerJs(
          "$('#exportar-".$idArea."').on('click', function(){
            var doc = new jsPDF();
            
            doc.fromHTML($('.contenedor-".$idArea."').html(), 15, 15, {
              'width': 170,
                  
            });
            doc.save('sample-file.pdf');
          });",
          View::POS_READY,
          $idArea
        );

        }
        ?>
        
      </div>
    </div>
  </div>
</div>
  </div>
</div>
</div>
