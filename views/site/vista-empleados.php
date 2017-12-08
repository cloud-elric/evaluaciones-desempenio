<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Equipo de trabajo</div>
<?php
foreach($empleados as $empleado){
?>
    
        <div class="panel-body">
            <h3><a href="<?= $link = Yii::$app->urlManager->createAbsoluteUrl(['site/preguntas-usuario2?token=' . $empleado->txt_token])?>">
                <?= $empleado->txt_username. " " .$empleado->txt_apellido_paterno ?>
            </a></h3> 
        </div>   
<?php
}
?>
    </div>
</div>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Otros empleados</div>
<?php
foreach($empleadosOtros as $empleadoOtro){
?>
    
        <div class="panel-body">
            <h3><a href="<?= $link = Yii::$app->urlManager->createAbsoluteUrl(['site/preguntas-usuario?token=' . $empleadoOtro->txt_token])?>">
                <?= $empleadoOtro->txt_username. " " .$empleadoOtro->txt_apellido_paterno ?>
            </a></h3> 
        </div>   
<?php
}
?>
    </div>
</div>