<?php
use yii\helpers\Url;
$this->title = "Dashboard";

$this->registerJsFile(
    '@web/webAssets/js/admin/index.js',
    ['depends' => [\app\assets\AppAssetClassicTopBar::className()]]
);

$this->registerCssFile(
    '@web/webAssets/templates/classic/topbar/assets/examples/css/app/mailbox.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="alert dark alert-success alert-dismissible d-none" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <strong>Listo</strong> Se han enviado mediante email el acceso para las evaluaciones
        </div>      
    </div>    
</div>

<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary float-right ladda-button" id="js-enviar-email" data-style="zoom-in" href="<?=Url::base()?>/admin/send-email">
            <span class="ladda-label">Enviar evaluaciones</span>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="panel">
            <div class="panel-body">
                <div class="list-group bg-blue-grey-100">
                    <a class="list-group-item blue-grey-500" 
                        href="<?= Url::base()."/admin/reporte-por-niveles"?>">
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