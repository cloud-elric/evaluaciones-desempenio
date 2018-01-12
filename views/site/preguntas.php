<?php
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

$this->title = "Evaluación de competencias";

$this->params['classBody'] = "page-login-v3 layout-full preguntas-page";


$this->registerJsFile(
    '@web/webAssets/js/site/preguntas.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/templates/classic/global/vendor/raty/jquery.raty.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/templates/classic/global/js/Plugin/raty.js',
    ['depends' => [\app\assets\AppAssetClassicTopBarBlank::className()]]
);

$this->registerCssFile(
    '@web/webAssets/css/site/preguntas.css',
    ['depends' => [\app\assets\AppAssetClassicTopBarBlank::className()]]
);

$this->registerCssFile(
    '@web/webAssets/templates/classic/topbar/assets/examples/css/advanced/rating.css',
    ['depends' => [\app\assets\AppAssetClassicTopBarBlank::className()]]
);
?>
<?php
$this->params['extra'] ='<div class="banda">
							<nav class="navbar navbar-inverse role="navigation">
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-12 text-center">
											
												Estas evaluando a: '.$usuarioEvaluar->nombreCompleto.' 
												<span class="badge badge-warning">
													'.$relacion->txt_tipo_evaluacion.'
												</span>
											
											<a class="btn btn-success float-right hidden-md-down" href="'.Url::base().'/site/evaluacion">
												<i class="icon wb-menu" aria-hidden="true"></i>
												Mis evaluaciones
											</a>
											<a class="btn btn-success hidden-lg-up" href="'.Url::base().'/site/evaluacion">
												<i class="icon wb-menu" aria-hidden="true"></i>
												Mis evaluaciones
											</a>
											<br>
										</div>
										
									</div>
							</nav>
						</div>';

?>

<?php
$i = 0;
foreach($cuestionarios as $cuestionario){
	$i++;
	$cuestionario = $cuestionario->idCuestionario;
	$preguntas = $cuestionario->entPreguntas;
?>
<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">
			Competencia <?=$i?>
			
		</h3>
			
	</div>
	<div class="panel-body">
		<form>
			<ul class="list-group list-group-full">
				<?php 
				$index = 0;
				foreach($preguntas as $pregunta){
				?>

				<li class="list-group-item">
						<div class="media">
							<div class="media-body">
								<h5 class="mt-0 mb-5"><?=($index+1).".- ".$pregunta->txt_pregunta?></h5>
								<p>
									<div class="rating rating-lg" data-plugin="rating" 
									data-score-name="respuesta[<?=$pregunta->id_pregunta?>]"></div>
								</p>
							</div>
						</div>	
				</li>
				
				<?php 
				$index++;
				}
				?>
			</ul>
			
			<div class="form-group text-center">
				<button class="btn btn-success js-guardar-cuestionario ladda-button" data-style="zoom-in" 
				data-eva="<?=$eva?>" data-token="<?=$cuestionario->id_cuestionario?>">
					<span class="ladda-label">
						Guardar cuestionario
					</span>	
				</button>
			</div>
		</form>
	</div>
</div>
<?php
}
?>
 