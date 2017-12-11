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
        var hasError = false;

        l.start();

        form.find('input').each(function(index){
            var input = $(this);
            var container = input.parents("blockquote");
            if(input.val()==""){
                container.addClass("error");
                hasError = true;
            }else{
                container.removeClass("error");
                container.addClass("success");
            }
        });

       
        if(hasError){
           
            swal(
                'Datos requeridos',
                'Debe responder todas las preguntas de la competencia actual',
                'warning'
              );
              l.stop();
        }else{
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
        }
    });

});

$(document).on({
    'click': function(){
        console.log($(this));
        var elemento = $(this);
        var contenedor = elemento.parents("blockquote");
        contenedor.addClass("success");
    }
}, ".rating i");

