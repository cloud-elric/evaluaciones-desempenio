<?php
use yii\web\View;

$this->registerJsFile(
    '@web/webAssets/templates/classic/global/vendor/chart-js/Chart.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    'https://unpkg.com/jspdf@latest/dist/jspdf.min.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/plugins/html2canvas/html2canvas.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerCssFile(
    '@web/webAssets/templates/classic/topbar/assets/examples/css/charts/chartjs.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

?>

<div class="page">
    <div class="page-content">
      <h2><?= $this->title ?></h2>
      <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <button id="exportButton">
                        Exportar
                    </button>
                </div>
            </div>
            <div class="row">
            <div class="col-md-6  preguntas">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <span class="badge badge-outline badge-success">Pregunta 1</span>
                        <br>  
                        Hace bien y correctamente su trabajo en cualquier proyecto y situación?                          
                    </p>
                </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                <p>
                <span class="badge badge-outline badge-success">Pregunta 2</span>
                <br>  
                Le hace saber a sus jefes y compañeros su deseo por hacer mejor su trabajo continuamente?                          </p>
                </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                <p>
                <span class="badge badge-outline badge-success">Pregunta 3</span>
                <br>  
                Utiliza herramientas de comparación para conocer con exactitud sus logros y avances?                          </p>
                </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                <p>
                <span class="badge badge-outline badge-success">Pregunta 4</span>
                <br>  
                Puede enfocarse a nuevas y más precisas maneras de cumplir con las metas establecidas por la gerencia?                          </p>
                </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                <p>
                <span class="badge badge-outline badge-success">Pregunta 5</span>
                <br>  
                Propone cambios  en los métodos de trabajo  para mejorar su desempeño?                          </p>
                </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                <p>
                <span class="badge badge-outline badge-success">Pregunta 6</span>
                <br>  
                Promueve  acciones especificas conseguir resultados únicos y específicos?                          </p>
                </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                <p>
                <span class="badge badge-outline badge-success">Pregunta 7</span>
                <br>  
                Toma decisiones, establece prioridades o determina metas calculadas?                          </p>
                </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                <p>
                <span class="badge badge-outline badge-success">Pregunta 8</span>
                <br>  
                Obtiene métricas y analiza los resultados de los proyectos o programas establecidos.?                          </p>
                </div>
                </div>


                </div>
                <div class="col-md-6">
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>
            </div>
            
        </div>
      </div>
    </div>
  </div>

  <?php
    $this->registerJs(
        '
        $(document).ready(function(){
            $("#exportButton").on("click",  function(){

                var w = 1000;
                var h = 1000;
                var div = document.querySelector(".preguntas");
                var canvas = document.createElement("canvas");
                canvas.width = w*2;
                canvas.height = h*2;
                canvas.style.width = w + "px";
                canvas.style.height = h + "px";
                var context = canvas.getContext("2d");
                context.scale(2,2);
                html2canvas(div, { canvas: canvas }).then(function(canvas) {
                    document.body.appendChild(canvas);
                    var chart = $("#myChart").get(0);
                    var dataURL = chart.toDataURL();
                    var dataURLPreguntas = canvas.toDataURL();
                    //console.log(dataURL);
    
                    var pdf = new jsPDF();
               
                
                    //
                    pdf.addImage(dataURLPreguntas, "PNG", 10, 10);
                    pdf.addPage();
                    pdf.addImage(dataURL, "PNG", 10, 10);
                
                    pdf.save("web.pdf");
                });

                return false;

                
               
                 
                
            });

        });
        

        var ctx = $("#myChart");
        var myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                datasets: [{
                    type: "bar",
                    label: "# of Votes",
                    data: [12, 19, 3, 5, 2, 3],
                   
                    borderWidth: 1
                },
                {
                    fill:false,
                    type: "line",
                     label: "# of Votess",
                    data: [12, 19, 3, 5, 2, 3],
                   showLine:false,
                    borderWidth: 1
                }
                ]
            },
            options: {
                tooltips:{
                    intersect: true,
                    mode: "index"
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
        ',
        View::POS_READY,
        'identificador'
    );
    ?>

