var alertSuccessTemplate = '';
var alertErrorTemplate = '';

$(document).ready(function(){
    $(".js-guardar-cuestionario").on("click", function(e){
        e.preventDefault();

        var elemento = $(this);
        var token = elemento.data("token");
        var eva = elemento.data("eva");
        var form = elemento.parents("form");
        var data = form.serialize();
        var l = Ladda.create(this);
        var panelContainer = elemento.parents(".panel");
       
        
        l.start();
        
        $.ajax({
            url:baseUrl+"site/guardar-preguntas-cuestionario?token="+token+"&eva="+eva,
            data: data,
            method: "POST",
            success:function(resp){

                if(resp.status=="success"){
                    panelContainer.addClass("animation-reverse animation-fade");
                    panelContainer.remove();
                }else{
                    
                }
                l.stop();
            },
            error: function(){
                l.stop();
            }
        });

    });
});


