$(document).ready(function(){

    $("#js-enviar-email").on("click", function(e){
        e.preventDefault();
        var elemento = $(this);

        var l = Ladda.create(this);
        

        $.ajax({
            url: baseUrl+"admin/send-email",
            success:function(resp){
                if(resp.status="success"){
                    $(".alert.alert-success").addClass("d-block");
                    $("#js-enviar-email .ladda-label").html("Evaluaciones enviadas exitosamente <i class='icon fa-check' aria-hidden='true'></i>");

                    setTimeout(() => {
                        $("#js-enviar-email .ladda-label").html('Enviar evaluaciones<i class="icon fa-send" aria-hidden="true"></i>');
                    }, 3000);
                }
                l.stop();
            }, error:function(){
                l.stop();
            }
        })

    });

    jQuery('a[data-toggle=tab]').on('shown.bs.tab', function() {
        $(window).trigger("resize");
        });


        $( window ).resize(function() {
            console.log( "<div>Handler for .resize() called.</div>" );
          });

});

$(document).ajaxStop(function(e) {
    console.log(e);
  });

