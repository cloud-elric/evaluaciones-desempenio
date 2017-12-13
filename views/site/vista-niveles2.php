<?php
use app\models\EntCuestionario;
?>

<div class="container">
    <ul class="nav nav-tabs nav-justified">
        <?php
        foreach($datos as $dato){
        ?>
            <li><a data-toggle="tab" href="#<?= $dato['nombreArea'] ?>"><?= $dato['nombreArea'] ?></a></li>
        <?php
        }
        ?>
    </ul>
    <div class="tab-content">
        <?php
        foreach($datos as $dato){
        ?>
            <div id="<?= $dato['nombreArea'] ?>" class="tab-pane fade">
                <?php
                foreach($dato['cuestionario'] as $cuest){
                    echo "<h3>" . $cuest['nombre'] . "</h3>";

                    foreach($cuest['resultados'] as $resultados){
                ?>
                        <p><?= $resultados ?></p>
                <?php
                    }
                }
                ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<div id="ct-chart-<?= $respuestaUsuario->id_pregunta ?>"></div>
                        <script>
                            new Chartist.Bar('#ct-chart-<?= $respuestaUsuario->id_pregunta ?>', {
                                labels: ['1', '2', '3', '4', '5'],
                                series: [
                                    [<?= $promedio1 ?>, <?= $promedio2 ?>, <?= $promedio3 ?>, <?= $promedio4 ?>, <?= $promedio5 ?>,]
                                ]
                            },{
                                width: 320,
                                height: 70,
                                seriesBarDistance: 10,
                                horizontalBars: true
                            });
                        </script>
