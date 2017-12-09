<?php
use app\models\EntPreguntas;
use yii\helpers\Html;

foreach($cuestionarios as $cuestionario){
    $preguntas = EntPreguntas::find()->where(['id_cuestionario'=>$cuestionario->id_cuestionario])->all();
?>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading"><?= $cuestionario->txt_nombre?></div>
            <div class="panel-body">
                <?php
                foreach($preguntas as $pregunta){
                ?>
                    <blockquote><?=$pregunta->txt_pregunta?></blockquote>
                    <blockquote>
                    <?php
                    $array = [1,2,3,4,5];
                    foreach($array as $arr){
                    ?>
                        <div class="col-md-2">
                            <div class="alert alert-info" role="alert">
                                <p>
                                    <?= Html::radio ( 'respuesta', false, [ 
                                        'value' => $arr,
                                        'class' => 'js_radio_preg'
                                    ]) . $arr ?>
                                </p>
                            </div>	
                        </div>
                    <?php
                    }
                    ?>
                    </blockquote>
                    <br/>
                    <br/>
                <?php
                }
                ?>
            </div>   
        </div>
    </div>
<?php
}
?>