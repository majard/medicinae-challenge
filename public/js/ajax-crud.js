
$(document).ready(function() {
    
    $(".create-clinic").click(function(e){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        
        e.preventDefault();

        var cnpj = $("input[name='cnpj']").val();

        var nome = $("input[name='nome']").val();        

        console.log(cnpj);
        console.log(nome);
        $.ajax({            
            
            url: "/cadastro/clinica",

            type:'POST',

            data: {cnpj:cnpj, nome:nome},

            success: function(data) {

                if($.isEmptyObject(data.error)){            

                    alert(data.success);

                }else{

                    console.log("deu ruim");
                }
            }
        });
    }); 

    function printErrorMsg (msg) {

        $(".print-error-msg").find("ul").html('');

        $(".print-error-msg").css('display','block');

        $.each( msg, function( key, value ) {

            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');

        });
    }
});
