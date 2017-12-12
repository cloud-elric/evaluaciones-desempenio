<?php

use yii\helpers\Url;
$this->title = "Dashboard";
?>

<div class="alert alert-success">
    <strong>Listo</strong> Se han enviado mediante email el acceso para las evaluaciones
</div>

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