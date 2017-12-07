<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Poner descripcion de proyecto">
    <meta name="author" content="2 Geeks one Monkey">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="<?= Url::base() ?>/webAssets/js/breakpoints.js"></script>
    <script>
      Breakpoints();
    </script>
    <script>
          var baseUrl = "<?= Yii::$app->urlManager->createAbsoluteUrl(['']) ?>";
      </script>
    <?php $this->head() ?>
</head>
<body class="site-navbar-small">
  <div class="animsition-loading"></div>
  <div class="animsition">
  <?php $this->beginBody() ?>

  <!-- Navbar -->
  <?= $this->render("nav-bar") ?>

  <!-- Top bar menu -->
  <?= $this->render("top-bar-menu") ?>

  <!-- Page -->
  <div class="page">
    <div class="page-header">
      <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
      <?=Breadcrumbs::widget([
        'homeLink' => [
          'label' => '<i class="icon wb-home"></i>Inicio',
          'url' => Yii::$app->homeUrl,
          'encode' => false// Requested feature
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options'=>['class'=>'breadcrumb breadcrumb-arrow']
      ]);?>
      <div class="page-header-actions hidden-xs">
        <?=isset($this->params['btnAcciones'])?$this->params['btnAcciones']:'';?>
      </div>
      <div class="col-md-12 text-center padding-top-10 visible-xs">
        <?=isset($this->params['btnAcciones'])?$this->params['btnAcciones']:'';?>
      </div>
    </div>
    <div class="page-content">
        <?= $content ?>
    </div>
  </div>
  <!-- End Page -->

  <!-- Footer -->
  <?=$this->render("footer")?>

  <?php $this->endBody() ?>
  </div>
  <script>
  (function(document, window, $) {
    'use strict';
    var Site = window.Site;
    $(document).ready(function() {
      Site.run();
    });
  })(document, window, jQuery);
  </script>
</body>
</html>
<?php $this->endPage() ?>
