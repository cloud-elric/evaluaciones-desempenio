var widthPaper = 210;
var heightPaper = 295;
var optionsGrafica =  {
    legend:{
        position:"bottom"
    },
    tooltips:{
        intersect: true,
        mode: "index"
    },
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero:true,
                stepSize: 1,
                max: 5 // Edit the value according to what you need
                
            }
        }]
    }
};
var colorInicial = "#62a8ea";
var colors = ["#3583CA", "#70A532", "#424242", "#E53B75", "#37A9B7",
             "#FBC02D", "#263238", "#6D45BC", "#178D81", "#E98F2E", 
             "#465BD4", "#279566", "#715146","#FA7A7A","#89BCEB","#ACD57C",
            "#9E9E9E","#F978A6","#77D6E1","#A58ADD","#56BFB5",
            "#F4B066", "#8897EC", "#5CD29D", "#A17768"
            ];

function calcularFactor($ancho, $alto, $redimension) {
    var factor = 0;
    if ($ancho >= $alto) {
        factor = $redimension / $ancho;
    } else if ($ancho <= $alto) {
        factor = $redimension / $alto;
    }
    
    return factor;
}

function descargarReportePDF(preguntasIdentificador, l, nombre){

    var w = 1000;
    var h = 1000;
    var div = document.querySelector(preguntasIdentificador);
    var canvas = document.createElement("canvas");
    canvas.width = w*2;
    canvas.height = h*2;
    canvas.style.width = w + "px";
    canvas.style.height = h + "px";
    var context = canvas.getContext("2d");
    context.scale(2,2);
    html2canvas(div, { canvas: canvas }).then(function(canvas) {

        var widthPreguntas = canvas.width;
        var heightPreguntas = canvas.height;
        var dataURLPreguntas = canvas.toDataURL();

        if(widthPreguntas >= widthPaper){
            var factor = calcularFactor(widthPreguntas, heightPreguntas, widthPaper-20);
            widthPreguntas = widthPreguntas * factor;
            heightPreguntas = heightPreguntas * factor;
        }

        // var chart = $(graficaIdentificador).get(0);
        // var widthGrafica = chart.width;
        // var heightGrafica = chart.height;
        // var dataURL = chart.toDataURL();

        // if(widthGrafica >= widthPaper){
        //     var factor = calcularFactor(widthGrafica, heightGrafica, widthPaper/2);
        //     widthGrafica = widthGrafica * factor;
        //     heightGrafica = heightGrafica * factor;
        // }
       
        var pdf = new jsPDF("p", "mm");
        //
        pdf.addImage(dataURLPreguntas, "PNG", 10, 10, widthPreguntas, heightPreguntas);
        //pdf.addPage();
        //pdf.addImage(dataURL, "PNG", 10, 10, widthGrafica, heightGrafica);
        //pdf.addImage(dataURL, "PNG", 10, 10);
    
        pdf.save(nombre+".pdf");
        l.stop();
    });

    return false;
}

