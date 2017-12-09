<?php
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

$this->title = "Cuestionarios";

$this->registerJsFile(
    '@web/webAssets/js/rating.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/plugins/rating/rating.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/js/cuestionarios.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>

<div class="row">
	<div class="col-md-12">
		<a href="<?=Url::base()?>/site/evaluacion" 
		class="btn btn-primary ladda-button" ladda-style="zoom-in">
			<span class="ladda-label">
				Ir al inicio
			</span>
		</a>
	</div>
</div>
<br>
<?php
foreach($cuestionarios as $cuestionario){
	$cuestionario = $cuestionario->idCuestionario;
	$preguntas = $cuestionario->entPreguntas;
?>
	<div class="panel panel-success">
		<div class="panel-heading">
			<?=$cuestionario->txt_nombre?>
		</div>
		<div class="panel-body">
			<form>
				<br>
				<?php 
				$index = 0;
				foreach($preguntas as $pregunta){
				?>
				<div class="row">
					<div class="col-md-12">
						<blockquote>
							<?=$pregunta->txt_pregunta?>
							<br>
							<div class="rating rating-lg" data-plugin="rating" data-score-name="respuesta[<?=$pregunta->id_pregunta?>]"></div>
						</blockquote>	
					</div>
				</div>
				<?php 
				$index++;
				}
				?>
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

