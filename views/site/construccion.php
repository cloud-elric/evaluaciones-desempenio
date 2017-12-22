<?php

use yii\web\View;
use yii\helpers\Url;
$this->title="Reporte por competencias";

$this->params['classBody'] = "page-error page-error-400 layout-full";


$this->registerCssFile(
  '@web/webAssets/templates/classic/topbar/assets/examples/css/pages/errors.css',
  ['depends' => [\app\assets\AppAsset::className()]]
);
?>

<div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
      <header>
        <h1 class="animation-slide-top">Espera</h1>
        <p>Esta página se encuentra en construcción</p>
      </header>
      <p class="error-advise">Pronto podrás visualizar esta página</p>
      <a class="btn btn-primary btn-round" href="<?=Url::base()?>">Ir a la pagina inicial</a>
     
    </div>
  </div>