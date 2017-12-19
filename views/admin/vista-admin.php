<?php 
use yii\helpers\Url;

$this->title = "Admin";
?>

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
                    href="<?= Url::base()."/site/competencias"?>">
                    <i class="icon wb-user" aria-hidden="true"></i>
                    Competencias
                </a>
                <a class="list-group-item blue-grey-500" 
                    href="<?= Url::base()."/site/empleados"?>">
                    <i class="icon wb-user" aria-hidden="true"></i>
                    Empleados
                </a>
            </div>  
        </div>    
    </div>
</div>
</div>