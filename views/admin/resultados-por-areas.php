<?php

use yii\web\View;
use yii\helpers\Url;
$this->title="Reporte por area";


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
  '@web/webAssets/plugins/xepOnline/jqPlugin.js',
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
  </div>
  <!-- Media Content -->
  <div id="mediaContent" class="page-content page-content-table">
  <div class="col-md-12">
  <div class="example-wrap">
    <div class="nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
      <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
        <?php
        $active = true;
        foreach($resultados as $index=>$resultado){
        ?>
        <li class="nav-item" role="presentation">
          <a class="nav-link <?=$active?'active':''?>" data-toggle="tab" href="#area-<?=$index?>"
           role="tab" aria-expanded="true">
          <?=$resultado['nombreArea']?>
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

        <div class="tab-pane <?=$active?'active':''?> animation-slide-left" id="area-<?=$idArea?>"
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
                        Número de encuestados totales:<?=$cuestionario["numeroEncuestados"]?>
                    </small><br>
                    Área <?=$resultado['nombreArea']?> - <?=$cuestionario["cuestionarioNombre"]?><br>
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
                      $minimo = '';
                      foreach($cuestionario['preguntas'] as $keys=>$pregunta){

                        if ($pregunta === end($cuestionario['preguntas'])) {
                          $preguntaT .= '"Pregunta '.++$index.'"';
                          $preguntaV .= $pregunta['promedio']."";
                          //$minimo .= $cuestionario["puntuacionPromedio"]."";
                        }else{
                          $preguntaT .= '"Pregunta '.++$index.'",';
                          $preguntaV .= $pregunta['promedio'].",";
                          //$minimo .= $cuestionario["puntuacionPromedio"].",";
                        }
                        
                      ?>
                      <div class="row">
                        <div class="col-md-12">
                          <p>
                          <span class="badge badge-outline badge-success">Pregunta <?=$index?></span>
                          <br>  
                          <?=$pregunta["textoPregunta"]?>
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
                        "
                        $('#exportar-".$cuestionario["identificador"]."').on('click', function(){
                          var l = Ladda.create(this);
      
                          xepOnline.Formatter.Format('container-export-".$cuestionario["identificador"]."', 
                            {
                              filename: 'Reporte área ".$resultado['nombreArea']." - ".$cuestionario["cuestionarioNombre"]."',
                              render: 'download'
                            });
                          l.stop();
                          return false;
                     
                                 
                        });
                        var simple_line_chart".$cuestionario["identificador"]." = c3.generate({
                          bindto: '#chart".$cuestionario["identificador"]."',
                          data: {
                            x: 'x',
                            columns: [
                              ['x', ".$preguntaT."],
                              ['puntuacion', ".$preguntaV."],
                            
                            ],
                            names: {
                              puntuacion: 'Total otros',
                              
                            },
                            
                            
                            type:'bar',
                            
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
                        });
                        $('svg').attr('xmlns','http://www.w3.org/2000/svg');
                        ",
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
