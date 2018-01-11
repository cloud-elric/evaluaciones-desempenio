// animisition: http://git.blivesta.com/animsition/
// ladda: http://msurguy.github.io/ladda-bootstrap/

$(document).ready(function() {
    // Animación entre pantallas
    // $(".animsition").animsition({
    //     transition: function(url){},
    //     loading : false
    //   });
      
    //   $('.animsition').on('animsition.inStart', function() {
    //     $(".animsition-loading").hide();
    //   });
    
    //   $('.animsition').on('animsition.outStart', function() {
    //     $(".animsition-loading").show();
    //   });
    
  
    //   // Cargador en todos los botones con la clase ladda
        $(".ladda-button").on("click", function(e){
           var l = Ladda.create(this);
           l.start();
           $('#form-ajax').submit();
    //   //   // Para deternerlo usar
    //   //   // var l = Ladda.create(this);
    //   //   // l.stop();
        });
  
      //Ladda.bind( '.ladda-button' );
      setTimeout(() => {
        if( $("body").css('opacity') == '0') {
            $("body").animsition('in');
          }    
      }, 800);
      
      
          $('#form-ajax').on('ajaxComplete', function (e, jqXHR, textStatus) {
            var l = Ladda.create($("#form-ajax button[type=submit]").get(0));
            l.stop();
            return true;
          });
  
      $(".input-number").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
  
  
      
  });

  
  function startPrintProcess(canvasObj, fileName, callback) {
    var pdf = new jsPDF('l', 'pt', 'a4'),
      pdfConf = {
        //pagesplit: false,
        background: '#fff'
      };
    document.body.appendChild(canvasObj); //appendChild is required for html to add page in pdf
    pdf.addHTML(canvasObj, 0, 0, pdfConf, function() {
      document.body.removeChild(canvasObj);
      pdf.addPage();
      pdf.save(fileName + '.pdf');
      callback();
    });
  }

  function resetForm(form) {
    // clearing inputs
    var inputs = form.getElementsByTagName('input');
    for (var i = 0; i<inputs.length; i++) {
        switch (inputs[i].type) {
            // case 'hidden':
            case 'text':
                $(inputs[i]).val("");
                break;
            case 'radio':
            case 'checkbox':
                inputs[i].checked = false;   
        }
    }

    // clearing selects
    var selects = form.getElementsByTagName('select');
    for (var i = 0; i<selects.length; i++)
        selects[i].selectedIndex = 0;

    // clearing textarea
    var text= form.getElementsByTagName('textarea');
    for (var i = 0; i<text.length; i++)
        text[i].innerHTML= '';

    return false;
}
  
  // Lanza la animación siempre que se cambie las pantallas
  window.onbeforeunload = function(){
    $('.animsition').animsition('out', $('.animsition'), '');
  }
  
