const SUCCESS_MESSAGE_DURATION = 1500;
const ERROR_MESSAGE_DURATION = 3000;
const REDIRECT_DELAY = 2000;
const FADE_IN_ANIMATION_TIMEOUT = 320;
const FADE_IN_ANIMATION_DURATION = 300;


$(document).ready(function() {
    // Create a clinic
    $(".create-clinic").click(function(e){
        $(this).prop('disabled', true);
        
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

                $('.errorNome').addClass('hidden');
                $('.errorCnpj').addClass('hidden');

                toastr.success('A clínica foi cadastrada com sucesso!', 'Sucesso!', {timeOut: SUCCESS_MESSAGE_DURATION});
                setTimeout(function(){
                    location.href='/clinicas';
                }, REDIRECT_DELAY);
            },
            
            error: function(data){
                $('.create-clinic').prop('disabled', false);
                var errors = data.responseJSON.errors;

                if (errors){
                    toastr.error('Erro de Validação!', 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});

                    var errors = data.responseJSON.errors;
                    
                    // Render the errors with js ...
                    if (errors.nome) {
                        $('.errorNome').removeClass('hidden');
                        $('.errorNome').text(errors.nome);
                    }
                    if (errors.cnpj) {
                        $('.errorCnpj').removeClass('hidden');
                        $('.errorCnpj').text(errors.cnpj);
                    }
                } 
                else {
                    toastr.error(data.responseJSON.message, 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
                }
            }
        });
    }); 

    // Open edit modal
    $(document).on('click', '.clinic.edit-modal', function() {
        $('.clinic.edit').prop('disabled', false);
        $('.modal-title').text('Edit');
        $('#nome_edit').val($('#nome').text());
        $('#cnpj_edit').val($('#cnpj').text());
        id = $(this).val();
        $('#editModal').modal('show');
    });
    
    // Edit a clinic
    $('.modal-footer').on('click', '.clinic.edit', function() {
        $(this).prop('disabled', true);

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
                $('.errorNome').addClass('hidden');
                $('.errorCnpj').addClass('hidden');
                $('#editModal').modal('hide');
                $('#nome').text(data.nome);       
                $('#cnpj').text(data.cnpj);
                $('#nome').val(data.nome);
                $('#cnpj').val(data.cnpj);

                toastr.success('A edição foi feita com sucesso!', 'Successo!', {timeOut: SUCCESS_MESSAGE_DURATION});                    
            },
            
            error: function(data){                                
                $('.clinic.edit').prop('disabled', false);
                var errors = data.responseJSON.errors;

                if (errors){
                    toastr.error('Erro de Validação!', 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});

                    // Render the errors with js
                    if (errors.nome) {
                        $('.errorNome').removeClass('hidden');
                        $('.errorNome').text(errors.nome);
                    }
                    if (errors.cnpj) {
                        $('.errorCnpj').removeClass('hidden');
                        $('.errorCnpj').text(errors.cnpj);
                    }
                } 
                else if (data.status == 403){
                    toastr.error('Você não pode editar essa clinica!', 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
                }
                else if (data.status == 409){
                    toastr.error('Já existe uma clinica com esse cnpj!', 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
                }
                else 
                {
                    toastr.error(data.responseJSON.message, 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
                }
            }
        });
    });

    // Open delete modal
    $(document).on('click', '.clinic.delete-modal', function() {
        $('.modal-title').text('Delete');
        $('#deleteModal').modal('show');
        id = $(this).val();
    });
    
    // delete a clinic
    $('.modal-footer').on('click', '.clinic.delete', function() {
        $(this).prop('disabled', true);

                
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'DELETE',
            url: '/clinicas/' + id,

            success: function(data) {
                toastr.success('A clinica foi deletada com sucesso!', 'Sucesso!', {timeOut: SUCCESS_MESSAGE_DURATION});
                setTimeout(function(){
                    location.href='/clinicas';
                }, REDIRECT_DELAY);
            },
            error: function(data) {
                $('.clinic.delete').prop('disabled', false);
                toastr.error(data.responseJSON.message, 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
            }
        });
    });

    // Create a HIC
    $(".create-health_insurance_company").click(function(e){
        
        $(this).prop('disabled', true);
        
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
                $('.errorNome').addClass('hidden');
                $('.errorImage').addClass('hidden');

                toastr.success('O plano de saúde foi cadastrado com sucesso!', 'Sucesso!', {timeOut: SUCCESS_MESSAGE_DURATION});
                setTimeout(function(){
                    location.href='/planos-de-saude';
                }, REDIRECT_DELAY);
            },
            
            error: function(data){
                $('.create-health_insurance_company').prop('disabled', false);

                var errors = data.responseJSON.errors;
                if (errors) {
                    toastr.error('Erro de Validação!', 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});

                    // Render the errors with js ...
                    if (errors.nome) {
                        $('.errorNome').removeClass('hidden');
                        $('.errorNome').text(errors.nome);
                    }
                    if (errors.image) {
                        $('.errorImage').removeClass('hidden');
                        $('.errorImage').text(errors.image);
                    }
                    if (errors.status) {
                        $('.errorStatus').removeClass('hidden');
                        $('.errorStatus').text(errors.status);
                    }
                } 
                else {
                    toastr.error(data.responseJSON.message, 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
                }
            }
        });
    });

    // Open modal to edit a HIC
    $(document).on('click', '.health-insurance.edit-modal', function() {
        $status = $('#status_edit');
        if ($status.val()) {
            $status.prop('checked', true);
        } else {
            $status.prop('checked', false);            
        }
        
        $('.health_insurance.edit').prop('disabled', false);
        $('.modal-title').text('Edit');
        $('#nome_edit').val($('#nome').text());
        $('#logo_edit').val($("#logo").text());
        id = $(this).val();
        $('#editModal').modal('show');
    });

    // Edit a HIC
    $('.modal-footer').on('click', '.health_insurance.edit', function() {
        $(this).prop('disabled', true);

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

                $('.errorNome').addClass('hidden');
                $('.errorImage').addClass('hidden');
                $('#editModal').modal('hide');
                $('#nome').text(data.nome);

                if (data.status) {
                    $status.val(true);
                    $status.prop('checked', true);
                    $('#status').text('Ativo');
                    $('#form_status_text').text('Ativo');
                }
                else {                    
                    $status.val(null);
                    $status.prop('checked', false);
                    $('#status').text('Inativo');
                    $('#form_status_text').text('Inativo');
                }
                
                if (formData.get('image')){
                    // update the image in the form
                    $("#form_logo_wrapper").load(location.href + " #form_logo_img");
                    
                    $("#logo_wrapper").fadeOut(FADE_IN_ANIMATION_DURATION);

                    //$("#logo_wrapper").animate({ width: '-=170px', height: '-=170px' }, FADE_IN_ANIMATION_DURATION);

                    setTimeout(function(){
                        $("#logo_wrapper").load(location.href + " #logo_img");

                        setTimeout(function(){
                            $("#logo_wrapper").fadeIn(FADE_IN_ANIMATION_DURATION);
                            //$("#logo_wrapper").animate({ width: '+=170px', height: '+=170px' }, FADE_IN_ANIMATION_DURATION);
                        }, FADE_IN_ANIMATION_TIMEOUT);
                    }, FADE_IN_ANIMATION_TIMEOUT);
                }

                toastr.success('A edição foi feita com sucesso!', 'Successo!', {timeOut: SUCCESS_MESSAGE_DURATION});                                    
            },
            
            error: function(data){
                $('.health_insurance.edit').prop('disabled', false);

                var errors = data.responseJSON.errors;

                if (errors){                    
                    toastr.error('Erro de Validação!', 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
                    
                    // Render the errors with js
                    if (errors.nome) {
                        $('.errorNome').removeClass('hidden');
                        $('.errorNome').text(errors.nome);
                    }
                    if (errors.image) {
                        $('.errorImage').removeClass('hidden');
                        $('.errorImage').text(errors.image);
                    }
                    if (errors.status) {
                        $('.errorStatus').removeClass('hidden');
                        $('.errorStatus').text(errors.status);
                    }
                } 
                else 
                {
                    toastr.error(data.responseJSON.message, 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
                }
            }
        });
    });
    
    // Toggle form status text based on checkbox input
    $(document).on('click', '#status_edit', function() {
        if ($(this).is(':checked')) {
            $('#form_status_text').text('Ativo');
            $(this).val(true);
        } else {
            $('#form_status_text').text('Inativo');
            $(this).val(null);
        }
    });
    
    // open modal to delete a health insurance company
    $(document).on('click', '.health_insurance.delete-modal', function() {
        $('.modal-title').text('Delete');
        $('#deleteModal').modal('show');
        id = $(this).val();
    });

    // delete a health insurance company
    $('.modal-footer').on('click', '.health_insurance.delete', function() {
        $(this).prop('disabled', true);
                
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'DELETE',
            url: '/planos-de-saude/' + id,

            success: function(data) {
                toastr.success('O plano de saúde foi deletada com sucesso!', 'Sucesso!', {timeOut: SUCCESS_MESSAGE_DURATION});
                setTimeout(function(){
                    location.href='/planos-de-saude';
                }, REDIRECT_DELAY);
            },
            error: function(data) {
                $(this).prop('disabled', false);
                toastr.error(data.responseJSON.message, 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
            }
        });
    });
    
    // open modal to add a relationship
    $(document).on('click', '.relationship.add-modal', function() {
        $('.modal-title').text('Adicionar plano de saúde');
        $('#addRelationshipModal').modal('show');
        clinic_id = $(this).val();
    });

    // add a relationship
    $(document).on('click', '.relationship.add', function() {
        
        health_insurance_company_id = $(this).val();
                
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'POST',
            url: '/relacionamento/' + clinic_id + '/' + health_insurance_company_id,

            success: function(data) {
                $("#hic_list").load(location.href + " #hic_list>*","");
                toastr.success('O relacionamento foi adicionado com sucesso!', 'Sucesso!', {timeOut: SUCCESS_MESSAGE_DURATION});
            },
            error: function(data) {
                console.log(data);
                if (data.status == 403){
                    toastr.error('Você não pode editar essa clinica!', 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
                }
                else {
                    toastr.error(data.responseJSON.message, 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
                }
            }
        });
    });
    
    // open modal to delete a relationship
    $(document).on('click', '.relationship.delete-modal', function() {
        $('.modal-title').text('Delete');
        $('#deleteRelationshipModal').modal('show');
        health_insurance_company_id = $(this).val();
        clinic_id = $('#deleteClinic').val();
    });

    // delete a relationship
    $('.modal-footer').on('click', '.relationship.delete', function() {
                
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'DELETE',
            url: '/relacionamento/' + clinic_id + '/' + health_insurance_company_id,

            success: function(data) {
                $("#hic_list").load(location.href + " #hic_list>*","");
                toastr.success('O relacionamento foi deletada com sucesso!', 'Sucesso!', {timeOut: SUCCESS_MESSAGE_DURATION});
            },            
            error: function(data) {
                if (data.status == 403){
                    toastr.error('Você não pode editar essa clinica!', 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
                }
                else {
                    toastr.error('Erro desconhecido.', 'Erro!', {timeOut: ERROR_MESSAGE_DURATION});
                }
            }
        });
    });

});
