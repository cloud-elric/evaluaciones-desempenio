<?php
use yii\helpers\Html;
use yii\web\View;
?>
<h3>Pregunta</h3>
<?php
echo Html::beginForm( [ 
    'preguntas-usuario?token='.$usuarioCuestionario->txt_token, 
], 'post', ['id'=> 'form_preg']);
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
		    <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <blockquote><?=$pregunta->txt_pregunta?></blockquote>
                        </div>
                        <div class="col-md-8 col-md-offset-2">
                            <?php
                            $array = [1,2,3,4,5];
							foreach($array as $arr){
							?>
								<div class="col-md-6">
									<div class="alert alert-info" role="alert">
										<p>
											<?= Html::radio ( 'respuesta', false, [ 
                                                'value' => $arr,
                                                'class' => 'js_radio_preg'
                                            ]) . $arr ?>
										</p>
									</div>	
								</div>
							<?php 
							}
							?>
						</div>
						<div class="col-md-12 text-center">
						<?=Html::submitButton('<span class="ladda-label">Siguiente</span>', ['id' => 'btn_siguinte', 'class' => 'btn btn-success ladda-button', 'data-style' => 'zoom-in'])?>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 

echo Html::endForm ();

$this->registerJs ( "
	$(window).bind('pageshow', function(event) {
        if (event.originalEvent.persisted) {
            window.location.reload() 
        }
    });
		
	$('#form_preg').submit(function(){
		var boton = Ladda.create(document.getElementById('btn_siguinte'));
		boton.start();
			
		if($('input.js_radio_preg').is(':checked')){
			return true;	
		}else{
			swal('Cuestionario', 'Necesitas contestar la pregunta!');
			boton.stop();
			return false;	
		}	
	});
", View::POS_END );
?>