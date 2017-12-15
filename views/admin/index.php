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

<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary  pull-right" href="<?=Url::base()?>/admin/send-email">
            Enviar evaluaciones
        </a>
    </div>
</div>


<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel">
            <div class="panel-body">
                <div class="list-group bg-blue-grey-100">
                    <a class="list-group-item blue-grey-500" 
                        href="<?= Url::base()."/site/niveles"?>">
                        <i class="icon wb-user" aria-hidden="true"></i>
                        Niveles
                    </a>
                    <a class="list-group-item blue-grey-500" 
                        href="<?= Url::base()."/site/niveles"?>">
                        <i class="icon wb-user" aria-hidden="true"></i>
                        Competencias
                    </a>
                    <a class="list-group-item blue-grey-500" 
                        href="<?= Url::base()."/site/niveles"?>">
                        <i class="icon wb-user" aria-hidden="true"></i>
                        Usuarios
                    </a>
                </div>  
            </div>    
        </div>
    </div>
</div>