<?php 
use yii\helpers\Url;
use app\models\EntRespuestas;
use app\models\RelCuestionarioArea;
use app\models\EntPreguntas;
use app\models\EntCuestionario;
use app\models\RelUsuarioRespuesta;

set_time_limit(500);

$this->title = "Vista por niveles";
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
                            $respuestasUsuario = $respuesta->relUsuarioRespuestas;
                            foreach($respuestasUsuario as $respuestaUsuario){
                                $pregunta = $respuestaUsuario->idPregunta;
                                if($pregunta->idCuestionario->id_cuestionario == $competencia->id_cuestionario){
                ?>
                                    <div id="ct-chart-<?= $respuestaUsuario->id_pregunta ?>"></div>
                                    <script>
                                        new Chartist.Bar('#ct-chart-<?= $respuestaUsuario->id_pregunta ?>', {
                                            labels: ['<?= $respuestaUsuario->id_pregunta ?>'],
                                            series: [
                                                [<?= $respuestaUsuario->txt_valor ?>]
                                            ]
                                        },{
                                            width: 320,
                                            height: 70,
                                            horizontalBars: true
                                        });
                                    </script>
                <?php
                                }
                            }
                        }
                    }
                }
                ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>