
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

                    toastr.success('A clínica foi cadastrada com sucesso!', 'Success Alert', {timeOut: 5000});

                }else{                            
                    toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                }
            }
        });
    }); 


    // Edit a clinic
    $(document).on('click', '.edit-modal', function() {
        $('.modal-title').text('Edit');
        $('#nome_edit').val($(this).data('nome'));
        $('#cnpj_edit').val($(this).data('cnpj'));
        id = $(this).val();
        $('#editModal').modal('show');
    });
    $('.modal-footer').on('click', '.edit', function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            
            type: 'PUT',
            url: '/clinicas/' + id,
            data: {
                'id': id,
                'nome': $('#nome_edit').val(),
                'cnpj': $('#cnpj_edit').val()
            },
            success: function(data) {
                $('.errorTitle').addClass('hidden');
                $('.errorContent').addClass('hidden');

                if ((data.errors)) {
                    setTimeout(function () {
                        $('#editModal').modal('show');
                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                    }, 500);

                    if (data.errors.title) {
                        $('.errorTitle').removeClass('hidden');
                        $('.errorTitle').text(data.errors.title);
                    }
                    if (data.errors.content) {
                        $('.errorContent').removeClass('hidden');
                        $('.errorContent').text(data.errors.content);
                    }
                } else {
                    toastr.success('A edição foi feita com sucesso!', 'Success Alert', {timeOut: 5000});                    
                }
            }
        });
    });


    // delete a clinic
    $(document).on('click', '.delete-modal', function() {
        $('.modal-title').text('Delete');
        $('#deleteModal').modal('show');
        id = $(this).val();
    });
    $('.modal-footer').on('click', '.delete', function() {
                
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'DELETE',
            url: '/clinicas/' + id,

            success: function(data) {
                toastr.success('A clinica foi deletada com sucesso!', 'Success Alert', {timeOut: 5000});
            }
        });
    });

    



    $(".create-health_insurance_company").click(function(e){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        
        e.preventDefault();
        
        console.log("chegou aqui");
        
        $.ajax({            
            
            url: "/cadastro/plano-de-saude",

            type:'POST',        
            processData: false,
            contentType: false,

            data: new FormData($("#upload_form")[0]),
            
            success: function(data) {

                if($.isEmptyObject(data.error)){         
                    console.log(data);
                    toastr.success('O plano de saúde foi cadastrado com sucesso!', 'Success Alert', {timeOut: 5000});

                }else{                    
                    toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                }
            }
        });
    });
});
