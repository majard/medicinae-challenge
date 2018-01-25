
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
    $(document).on('click', '.clinic.edit-modal', function() {
        $('.modal-title').text('Edit');
        $('#nome_edit').val($(this).data('nome'));
        $('#cnpj_edit').val($(this).data('cnpj'));
        id = $(this).val();
        $('#editModal').modal('show');
    });
    $('.modal-footer').on('click', '.clinic.edit', function() {

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
    $('.modal-footer').on('click', '.clinic.delete', function() {
                
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


    
    // Edit a clinic
    $(document).on('click', '.health-insurance.edit-modal', function() {
        $('.modal-title').text('Edit');
        $('#nome_edit').val($(this).data('nome'));
        $('#status_edit').val($(this).data('status'));
        $('#logo_edit').val($(this).data('logo'));
        id = $(this).val();
        $('#editModal').modal('show');
    });
    $('.modal-footer').on('click', '.health_insurance.edit', function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        var formData = new FormData($("#upload_form")[0]);
        formData.append('_method', 'PUT');

        $.ajax({
            
            type: 'POST',
            url: '/planos-de-saude/' + id,                
            
            processData: false,
            contentType: false,

            data: formData,
            
            success: function(data) {

                console.log(data);
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
    
    // delete a health insurance company
    $(document).on('click', '.health_insurance.delete-modal', function() {
        $('.modal-title').text('Delete');
        $('#deleteModal').modal('show');
        id = $(this).val();
    });
    $('.modal-footer').on('click', '.health_insurance.delete', function() {
        console.log("gonna delete");
                
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'DELETE',
            url: '/planos-de-saude/' + id,

            success: function(data) {
                toastr.success('O plano de saúde foi deletada com sucesso!', 'Success Alert', {timeOut: 5000});
            }
        });
    });

});
