<?php

use yii\web\View;
$this->title="Reporte por empleados";

$this->params['classBody'] = "site-navbar-small dashboard-admin";

$this->registerJsFile(
  '@web/webAssets/templates/classic/global/vendor/d3/d3.min.js',
  ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
  '@web/webAssets/templates/classic/global/vendor/c3/c3.min.js',
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
        <div id="mediaContent" class="page-content page-content-table">
            <div class="col-md-12">
                <div class="example-wrap">
                    <div class="panel">
                        <div class="panel-body">
                            <?php
                            foreach($resultados as $index=>$empleado){
                               
                            ?>  
                                <div class="panel">
                                    <div class="panel-body">
                                        <section>
                                            <h6 class="panel-title">
                                                <?=$empleado["nombre"]?><br>
                                                <small>
                                                    <?=$empleado["promedio"]?>
                                                </small>
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?php
                                                    $cuestionarioNombre = '';
                                                    $cuestionarioValor = '';
                                                    $i= 0;
                                                    foreach($empleado["cuestionarios"] as $cuestionario){
                                                        if ($cuestionario === end($empleado["cuestionarios"])) {
                                                            $cuestionarioNombre .= '"Competencia '.++$i.'"';
                                                            $cuestionarioValor .= $cuestionario['promedio']."";
                                                            
                                                        }else{
                                                            $cuestionarioNombre .= '"Competencia '.++$i.'",';
                                                            $cuestionarioValor .= $cuestionario['promedio'].",";
                                                        
                                                        }
                                                    ?>
                                                     <div class="row">
                                                        <div class="col-md-12">
                                                            <p>
                                                            <span class="badge badge-outline badge-success">Competencia <?=$i?></span>
                                                            <br>  
                                                            <?=$cuestionario["nombreCuestionario"]?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                                <div class="col-md-6">
                                                    <div id="chart<?=$index?>"></div>
                                                    <?php
                                                    $this->registerJs(
                                                    "var simple_line_chart".$index." = c3.generate({
                                                        bindto: '#chart".$index."',
                                                        data: {
                                                        x: 'x',
                                                        columns: [
                                                            ['x', ".$cuestionarioNombre."],
                                                            ['Puntuación', ".$cuestionarioValor."],
                                                        
                                                        ],
                                                    
                                                        
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
                                                    });",
                                                    View::POS_READY,
                                                    $index
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
                </div>
            </div>
        </div>
    </div>
</div>