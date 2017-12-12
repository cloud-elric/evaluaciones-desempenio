<?php

use yii\helpers\Url;
$this->title = "Dashboard";
?>

<?php
if(\Yii::$app->getSession()->hasFlash('success')){
?>

        
<div class="alert alert-success">
    <strong>Listo</strong> Se han enviado mediante email el acceso para las evaluaciones
</div>
<?php 
}
?>
<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" href="<?=Url::base()?>/admin/send-email">
                    Enviar evaluaciones
                </a>
            </div>
        </div>
    </div>
</div>