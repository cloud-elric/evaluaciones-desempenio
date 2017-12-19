$(document).ready(function(){

    $("#js-enviar-email").on("click", function(e){
        e.preventDefault();

        var l = Ladda.create(this);
        

        $.ajax({
            url: baseUrl+"admin/send-email",
            success:function(resp){
                if(resp.status="success"){
                    $(".alert.alert-success").addClass("d-block");
                   
                }
                l.stop();
            }, error:function(){
                l.stop();
            }
        })

    })

});