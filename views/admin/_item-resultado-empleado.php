<?php

use app\models\EntRespuestas;
use yii\web\View;
$nivel = $model->idNivel;

$cuestionariosRel = $nivel->relCuestionarioNiveles;
$cuestionarios = [];
$totalEmpleado = 0;
foreach($cuestionariosRel as $cuestionarioRel){

    $respuestas = EntRespuestas::find()->where(['!=', 'id_usuario', $model->id_usuario])->andWhere(["id_cuestionario"=>$cuestionarioRel->id_cuestionario, "id_usuario_evaluado"=>$model->id_usuario])->all();
    $respuestasAutoevaluacion = EntRespuestas::find()->where(['=', 'id_usuario', $model->id_usuario])->andWhere(["id_cuestionario"=>$cuestionarioRel->id_cuestionario, "id_usuario_evaluado"=>$model->id_usuario])->all();

    $promedio = 0;
    $total = 0;
    $numValores = 0;
    
    foreach($respuestas as $respuesta){
        $respuestasValores = $respuesta->relUsuarioRespuestas;

        foreach($respuestasValores as $respuestaValor){
            $numValores++;
            $total +=$respuestaValor->txt_valor;
        }
    }

    $promedioAuto = 0;
    $totalAuto = 0;
    $numValoresAuto = 0;
    foreach($respuestasAutoevaluacion as $respuetaAutoevaluacion){
        $respuestasValores = $respuetaAutoevaluacion->relUsuarioRespuestas;

        foreach($respuestasValores as $respuestaValor){
            $numValoresAuto++;
            $totalAuto +=$respuestaValor->txt_valor;
        }
    }

    if($numValores>0){
        $promedio = round(($total / $numValores), 1);
    }

    if($numValoresAuto>0){
        $promedioAuto = round(($totalAuto / $numValoresAuto), 1);
    }
    
    $totalEmpleado = $totalEmpleado + $promedio;

    $cuestionarios[]=[
        'nombreCuestionario'=>$cuestionarioRel->idCuestionario->txt_nombre,
        'promedio'=>$promedio,
        'promedioAuto'=>$promedioAuto,
        'total'=>$total,
        'numValores'=>$numValores,
        'respuestas'=>$respuestas,
        'puntuacionMinima'=>$cuestionarioRel->num_puntuacion
    ];
}

$promedioEmpleado = $totalEmpleado / count($cuestionariosRel);
$index = $model->id_usuario;
$empleado = [
    'nombre'=>$model->nombreCompleto,
    'promedio'=>round($promedioEmpleado, 1),
    'cuestionarios'=>$cuestionarios,
    //'totalEmpleado'=>$totalEmpleado
];
?>
<div class="panel">
    <div class="panel-body">
        <section>
            <h6 class="panel-title">
                <?= $empleado["nombre"] ?><br>
                <small>
                    <?= $empleado["promedio"] ?>
                </small>
            </h6>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    $cuestionarioNombre = '';
                    $cuestionarioValor = '';
                    $i = 0;
                    $minimo = '';
                    $cuestionarioValorAuto = '';
                    foreach ($empleado["cuestionarios"] as $cuestionario) {
                        if ($cuestionario === end($empleado["cuestionarios"])) {
                            $cuestionarioNombre .= '"Competencia ' . ++$i . '"';
                            $cuestionarioValor .= $cuestionario['promedio'] . "";
                            $minimo .= $cuestionario["puntuacionMinima"] . "";
                            $cuestionarioValorAuto .= $cuestionario["promedioAuto"] . "";
                        } else {
                            $cuestionarioNombre .= '"Competencia ' . ++$i . '",';
                            $cuestionarioValor .= $cuestionario['promedio'] . ",";
                            $minimo .= $cuestionario["puntuacionMinima"] . ",";
                            $cuestionarioValorAuto .= $cuestionario["promedioAuto"] . ",";
                        }
                        ?>
                        <div class="row">
                        <div class="col-md-12">
                            <p>
                            <span class="badge badge-outline badge-success">Competencia <?= $i ?></span>
                            <br>  
                            <?= $cuestionario["nombreCuestionario"] ?>
                            </p>
                        </div>
                    </div>
                
                    <?php

                }
                ?>

                </div>
                <div class="col-md-6">
                    <div id="chart<?= $index ?>"></div>
                    <?php
                    if (Yii::$app->request->isAjax) {
                    ?>
                    <script>
                        $(document).ready(function(){
                            var simple_line_chart<?=$index?> = c3.generate({
                                bindto: '#chart<?=$index?>',
                                data: {
                                    x: 'x',
                                    columns: [
                                        ['x', <?=$cuestionarioNombre?>],
                                        ['Puntuación', <?=$cuestionarioValor?>],
                                        ['data1', <?=$minimo?> ],
                                        ['data2', <?=$cuestionarioValorAuto?> ],
                                    ],
                                    names: {
                                        data1: 'Puntuación requerida',
                                        data2: 'Puntuación autoevaluación',
                                        },
                                    colors: {
                                        data1: 'rgb(255, 233, 0)',
                                    },
                                    types: {
                                        data1: 'line',
                                        data2: 'line',
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

                            $(window).trigger("resize");
                        });
                        
                    </script>

                    <?php
                    }else{

                        $this->registerJs(
                            "var simple_line_chart" . $index . " = c3.generate({
                            bindto: '#chart" . $index . "',
                            data: {
                            x: 'x',
                            columns: [
                                ['x', " . $cuestionarioNombre . "],
                                ['Puntuación', " . $cuestionarioValor . "],
                                ['data1', " . $minimo . " ],
                                ['data2', " . $cuestionarioValorAuto . " ],
                            ],
                            names: {
                                data1: 'Puntuación requerida',
                                data2: 'Puntuación autoevaluación',
                                },
                            colors: {
                                data1: 'rgb(255, 233, 0)',
                            },
                            types: {
                                data1: 'line',
                                data2: 'line',
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
                        });",
                            View::POS_END,
                            $index
                        );
                    }    
                    ?>
                </div>
            </div>    
        </section>    
    </div>
</div>