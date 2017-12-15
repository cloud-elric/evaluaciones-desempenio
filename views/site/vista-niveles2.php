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
                    $arrayDatos = [];
                    $i=0;
                    foreach($cuest['resultados'] as $resultados){
                        $arrayDatos[$i] = $resultados;
                        $i++;
                    }
                ?>
                    <div id="chart-<?= $dato['nombreArea'] . "-" . $cuest['idCuestionario'] ?>"></div>
                    <script>
                        new Chartist.Bar('#chart-<?= $dato['nombreArea'] . "-" . $cuest['idCuestionario'] ?>', {
                            labels: ['1', '2', '3', '4', '5'],
                            series: [
                                [<?php foreach($arrayDatos as $arr){ echo $arr.","; } ?>]
                            ]
                        },{
                            width: 320,
                            height: 250,
                            seriesBarDistance: 10,
                            horizontalBars: true
                        });
                    </script>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>

