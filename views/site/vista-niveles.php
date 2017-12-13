<?php 
use yii\helpers\Url;
use app\models\EntRespuestas;
use app\models\RelCuestionarioArea;
use app\models\EntPreguntas;
use app\models\EntCuestionario;
use app\models\RelUsuarioRespuesta;

set_time_limit(500);

$this->title = "Vista por niveles";

$valor1 = 0;
$valor2 = 0;
$valor3 = 0;
$valor4 = 0;
$valor5 = 0;
$numEncuestados = 0;
?>

<div class="container">
    <ul class="nav nav-tabs nav-justified">
        <?php
        foreach($niveles as $nivel){
        ?>
            <li><a data-toggle="tab" href="#<?= $nivel->txt_nombre ?>"><?= $nivel->txt_nombre ?></a></li>
        <?php
        }
        ?>
    </ul>
    <div class="tab-content">
        <?php
        foreach($niveles as $nivel){
        ?>
            <div id="<?= $nivel->txt_nombre ?>" class="tab-pane fade">
                <?php
                $relCuesArea = RelCuestionarioArea::find()->where(['id_area'=>$nivel->id_area])->select('id_cuestionario')->all();
                $competencias = EntCuestionario::find()->where(['in', 'id_cuestionario', $relCuesArea])->all();
                
                foreach($competencias as $competencia){
                    $respuestas = EntRespuestas::find()->where(['in', 'id_cuestionario', $relCuesArea])->all();
                    echo "<h3>" . $competencia->txt_nombre . "</h3>";

                    foreach($respuestas as $respuesta){
                        $usuario = $respuesta->idUsuarioEvaluado;
                        if($usuario->id_area == $nivel->id_area){
                            $numEncuestados = $numEncuestados + 1;
                            $respuestasUsuario = $respuesta->relUsuarioRespuestas;
                            foreach($respuestasUsuario as $respuestaUsuario){
                                $pregunta = $respuestaUsuario->idPregunta;
                                if($pregunta->idCuestionario->id_cuestionario == $competencia->id_cuestionario){
                                    if($respuestaUsuario->txt_valor == '1'){
                                        $valor1 = $valor1 + 1;
                                    }else if($respuestaUsuario->txt_valor == '2'){
                                        $valor2 = $valor2 + 1;                                        
                                    }else if($respuestaUsuario->txt_valor == '3'){
                                        $valor3 = $valor3 + 1;                                        
                                    }else if($respuestaUsuario->txt_valor == '4'){
                                        $valor4 = $valor4 + 1;                                        
                                    }else{
                                        $valor5 = $valor5 + 1;                                        
                                    }
                                }
                            }
                        }
                    }
                    $promedio1 = $valor1 / $numEncuestados;
                    $promedio2 = $valor2 / $numEncuestados;
                    $promedio3 = $valor3 / $numEncuestados;
                    $promedio4 = $valor4 / $numEncuestados;
                    $promedio5 = $valor5 / $numEncuestados;


                ?>
                    <div id="ct-chart-<?= $respuestaUsuario->id_pregunta ?>"></div>
                    <script>
                        new Chartist.Bar('#ct-chart-<?= $respuestaUsuario->id_pregunta ?>', {
                            labels: ['1', '2', '3', '4', '5'],
                            series: [
                                [<?= $promedio1 ?>, <?= $promedio2 ?>, <?= $promedio3 ?>, <?= $promedio4 ?>, <?= $promedio5 ?>,]
                            ]
                        },{
                            width: 320,
                            height: 70,
                            seriesBarDistance: 10,
                            horizontalBars: true
                        });
                    </script>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>