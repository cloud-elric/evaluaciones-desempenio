<?php
$this->title="Dashboard";

$this->params['classBody'] = "site-navbar-small app-media page-aside-left";

$this->registerJsFile(
    '@web/webAssets/js/admin/index.js',
    ['depends' => [\app\assets\AppAssetClassicTopBar::className()]]
);
?>
<div class="page bg-white">
<!-- Media Sidebar -->
<div class="page-aside">
  <div class="page-aside-switch">
    <i class="icon wb-chevron-left" aria-hidden="true"></i>
    <i class="icon wb-chevron-right" aria-hidden="true"></i>
  </div>
  <div class="page-aside-inner page-aside-scroll">
    <div data-role="container">
      <div data-role="content">
        <section class="page-aside-section">
          <h5 class="page-aside-title">Reportes</h5>
          <div class="list-group">
            <a class="list-group-item" href="javascript:void(0)"><i class="icon wb-pluse" aria-hidden="true"></i>Niveles</a>
            <a class="list-group-item" href="javascript:void(0)"><i class="icon fa-users" aria-hidden="true"></i>Por empleado</a>
            <a class="list-group-item" href="javascript:void(0)"><i class="icon fa-bolt" aria-hidden="true"></i>Por competencia</a>
          </div>
        </section>
        
      </div>
    </div>
  </div>
</div>
<!-- Media Content -->
<div class="page-main">
  <!-- Media Content Header -->
  <div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <div class="page-header-actions">
        <button class="btn btn-success float-right ladda-button" id="js-enviar-email" data-style="zoom-in">
            <span class="ladda-label">
                Enviar evaluaciones
                <i class="icon fa-send" aria-hidden="true"></i>
            </span>
            
        </button>
    </div>
  </div>
  <!-- Media Content -->
  <div id="mediaContent" class="page-content page-content-table">
   
  </div>
</div>
</div>
