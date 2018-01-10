<?php 
use yii\helpers\Url;
use app\models\EntRespuestas;
use app\models\RelCuestionarioNiveles;

#$link = Yii::$app->urlManager->createAbsoluteUrl(['site/preguntas-usuario?token=' . $empleado->txt_token]);
$this->title = "Evaluación";

$this->params['classBody'] = "page-login-v3 layout-full";
?>

<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">
      Evaluación
    </h3>
  </div>
  <div class="panel-body">
    <div class="brand">
      <img class="brand-img mb-40" src="<?=Url::base()?>/webAssets/images/logo.png" alt="...">
    </div>
    <div class="list-group list-group-dividered list-group-full">
      <?php
        foreach($usuariosCalificar as $usuario){
            $empleadoCalificar = $usuario->idUsuarioCalificado;
            $usuario->b_completado = validarCuestionariosRestantes($empleadoCalificar, $usuario);
            ?>    
      
            
            <a class="list-group-item blue-grey-500" 
                href="<?=$usuario->b_completado?"javascript:void(0)":Url::base()."/site/preguntas-usuario?token=".$empleadoCalificar->txt_token?>">
                <div class="media">
                  <div class="pr-20">
                    <?=$empleadoCalificar->nombreCompleto?><br>
                    <small><?=$usuario->txt_tipo_evaluacion?></small>
                  </div>
                  <div class="media-body">
                    <div class="float-right">
                      <span class="badge badge-<?=$usuario->b_completado?"success":"warning"?>"><?=$usuario->b_completado?"Completado":"Pendiente"?></span>
                    </div>
                    
                  </div>
                </div>


            </a>
              

            <?php
            }
        ?>
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
        $cuestionarios = RelCuestionarioNiveles::find()
                            ->where(['id_nivel'=>$empleadoCalificar->id_nivel])
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