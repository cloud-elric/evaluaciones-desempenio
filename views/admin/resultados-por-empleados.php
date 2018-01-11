<?php

use yii\web\View;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
$this->title="Reporte por individuales";

$this->params['classBody'] = "site-navbar-small dashboard-admin";

$this->registerJsFile(
  '@web/webAssets/templates/classic/global/vendor/d3/d3.min.js',
  ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
  '@web/webAssets/templates/classic/global/vendor/c3/c3.min.js',
  ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    'http://canvg.github.io/canvg/canvg.js',
    ['depends' => [\app\assets\AppAsset::className()]]
  );
  
  $this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js',
    ['depends' => [\app\assets\AppAsset::className()]]
  );
  
  $this->registerJsFile(
    '@web/webAssets/plugins/jspdf/jspdf.js',
    ['depends' => [\app\assets\AppAsset::className()]]
  );

$this->registerCssFile(
  '@web/webAssets/css/admin/index.css',
  ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerCssFile(
  '@web/webAssets/templates/classic/global/vendor/c3/c3.css',
  ['depends' => [\app\assets\AppAsset::className()]]
);
?>
<div class="page">
    <!-- Media Content -->
    <div class="page-main">
        <!-- Media Content Header -->
        <div class="page-header">
            <h1 class="page-title"><?=$this->title?></h1> 
        </div>
        
        <div id="mediaContent" class="page-content page-content-table">
            <div class="col-md-12">
                <div class="example-wrap">
                    <div class="panel">
                        <div class="panel-body pt-20">
                            <div class="row">
                                <div class="col-md-4">
                                    
                                    <?php
                                    
                                    require(__DIR__ . '/../components/select2.php');
                                    $url = Url::to(['ent-usuarios/buscar-empleado']);
                                    //$equipo = empty($model->id_equipo) ? '' : CatEquipos::findOne($model->id_equipo)->txt_nombre;
                                    // render your widget
                                    echo Select2::widget([
                                        'name' => 'search-empleado',
                                        // 'value' => '14719648',
                                        // 'initValueText' => 'kartik-v/yii2-widgets',
                                        'options' => ['placeholder' => 'Buscar individual'],
                                        'pluginEvents'=>[
                                            "select2:select" => "function(e) { 
                                                console.log(e); 
                                                $.pjax.reload({
                                                    container:'#p0',
                                                    url: baseUrl+'admin/resultados-por-empleados?us='+e.params.data.id,
                                                    replace:false});
                                                
                                            }",
                                            "select2:unselect" => "function() { 
                                                $.pjax.reload({
                                                    container:'#p0',
                                                    url: baseUrl+'admin/resultados-por-empleados',
                                                    replace:false});
                                                
                                            }"
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'minimumInputLength' => 3,
                                            'ajax' => [
                                                'url' => $url,
                                                'dataType' => 'json',
                                                'delay' => 250,
                                                'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                                'processResults' => new JsExpression($resultsJs),
                                                'cache' => true
                                            ],
                                             'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                             'templateResult' => new JsExpression('formatRepoEquipo'),
                                             'templateSelection' => new JsExpression('function (equipo) { 
                                                 if(equipo.text){
                                                    return equipo.text; 
                                                 }
                                                 return equipo.txt_nombre; 
                                                }'),
                                        ],
                                    ]);
                                
                                    ?>
                                </div>
                                <div class="col-md-8">
                                    <button class="btn btn-primary float-right ladda-button" data-style="zoom-in" id="exportar">
                                            <span class="ladda-label">
                                                <i class="icon oi-file-pdf" aria-hidden="true"></i>
                                                Exportar
                                            </span>
                                    </button>
                                </div>
                            </div>
                            <div id="contenedor">
                            <?php
                            Pjax::begin();  
                            echo ListView::widget([
                                'dataProvider' => $dataProvider,
                                'layout'        => "{items}<div class=\"col-md-12\">\n{pager}</div>",
                                'itemOptions' => ['class' => 'item'],
                                'itemView' => '_item-resultado-empleado',
                                'pager' => [
                                    'class' => ScrollPager::className(),
                                    'triggerText'=>'Cargar más datos',
                                    'noneLeftText'=>'No hay datos por cargar',
                                    'triggerOffset'=>999999999,
                                    'negativeMargin'=>100,
                                    'enabledExtensions' => [
                                        ScrollPager::EXTENSION_TRIGGER,
                                        ScrollPager::EXTENSION_SPINNER,
                                        ScrollPager::EXTENSION_NONE_LEFT,
                                        ScrollPager::EXTENSION_PAGING,
                                    ],
                                    // ScrollPager::EXTENSION_SPINNER,
                                    // ScrollPager::EXTENSION_PAGING,
                                ]
                           ]);
                           Pjax::end();
                            ?>

                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php
$this->registerJs(
    "$('#exportar').on('click', function(){

    var l = Ladda.create(this);
    
    html2canvas(document.querySelector('#w1')).then(canvas => {
        var dataURL = canvas.toDataURL();
        var nombreReporte = 'Reporte por individuales';
        $.ajax({
        url:'".Url::to('generar-reporte-pdf')."?nombreReporte='+nombreReporte,
        method: 'POST',
        data: {data64:dataURL},
        success: function(resp){
            var url = '".Url::to('descargar-reporte-pdf')."?nombreArchivo='+resp+'&nombreReporte='+nombreReporte;
            document.getElementById('iframe').src = url;
            l.stop();
        }
        });
    });

    
    });",
    View::POS_READY,
    "exportar"
);
?>
</div>
<div class="contenedor-iframe">
<iframe id='iframe' style='display:none;'></iframe>
</div> 