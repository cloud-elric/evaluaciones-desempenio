<?php 
use yii\helpers\Url;
use app\models\EntRespuestas;
use app\models\RelCuestionarioArea;

#$link = Yii::$app->urlManager->createAbsoluteUrl(['site/preguntas-usuario?token=' . $empleado->txt_token]);
$this->title = "Evaluación";
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel">
            <div class="panel-body">
                <div class="list-group bg-blue-grey-100">
                    <?php
                    foreach($usuariosCalificar as $usuario){
                        $empleadoCalificar = $usuario->idUsuarioCalificado;
                        $usuario->b_completado = validarCuestionariosRestantes($empleadoCalificar, $usuario);
                        ?>    
                        <a class="list-group-item blue-grey-500" 
                            href="<?=$usuario->b_completado?"javascript:void(0)":Url::base()."/site/preguntas-usuario?token=".$empleadoCalificar->txt_token?>">
                            <i class="icon wb-user" aria-hidden="true"></i> 
                            <span class="badge badge-<?=$usuario->b_completado?"success":"warning"?>"><?=$usuario->b_completado?"Compleado":"Pendiente"?></span>
                            <?=$empleadoCalificar->nombreCompleto?>
                        </a>
                        <?php
                        }
                    ?>
                </div>  
            </div>    
        </div>
    </div>
</div>
<?php
function validarCuestionariosRestantes($empleadoCalificar, $usuario){

    if(!$usuario->b_completado){
        $usuarioLog = Yii::$app->user->identity;
        
        $cuestionariosEvaluados = [];
        $cuestionariosCompletos = EntRespuestas::find()
            ->where(['id_usuario'=>$usuarioLog->id_usuario])
            ->andWhere(['id_usuario_evaluado'=>$empleadoCalificar->id_usuario])->all();

        foreach($cuestionariosCompletos as $cuestionario){
            $cuestionariosEvaluados[] = $cuestionario->id_cuestionario;

        }    
        $cuestionarios = RelCuestionarioArea::find()
                            ->where(['id_area'=>$empleadoCalificar->id_area])
                            ->andWhere(['not in', 'id_cuestionario', $cuestionariosEvaluados])
                            ->count();

        if($cuestionarios==0){
            $usuario->b_completado = 1;
            $usuario->save();
            return $usuario->b_completado;
        }
        
    }

    return $usuario->b_completado;
                                
}