<h2>Resultados por competencia</h2>
<div class="container">
    <ul class="nav nav-tabs nav-justified">
        <li class="active"><a data-toggle="tab" href="#todas">Todas</a></li>
    </ul>
    <div class="tab-content">
        <div id="#todas" class="tab-pane active in">
            <?php
            foreach($datos as $dato){
                //var_dump($dato);exit;
                echo "<h3>" . $dato['nombreCompetencia'] . "</h3>";
                foreach($dato['cuestionario'] as $cuest){
                    //var_dump($cuest);exit;
                    $arrayDatos = [];
                    $i=0;
                    foreach($cuest as $cue){
                        $arrayDatos[$i] = $cue;
                        $i++;
                    }
                }//var_dump($arrayDatos);exit;
                ?>
                <div id="chart-<?= $dato['idCuestionario'] ?>"></div>
                <script>
                    new Chartist.Bar('#chart-<?= $dato['idCuestionario'] ?>', {
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
    </div>
</div>