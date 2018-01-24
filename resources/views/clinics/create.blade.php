@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Clinic Form -->
        <form action="/cadastro/clinica" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Clinic Info -->
            <div class="form-group">
                <label for="clinic" class="col-sm-3 control-label">Clinic</label>

                <div class="col-sm-6">
                    <input type="text" name="cnpj" id="clinic-cnpj" class="form-control">
                </div>
                <div class="col-sm-6">
                    <input type="text" name="nome" id="clinic-name" class="form-control">
                </div>
            </div>

            <!-- Add Clinic Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Clinic
                    </button>
                </div>
            </div>
        </form>
    </div>
    
<script type="text/javascript">


    $(document).ready(function() {

        $(".btn-submit").click(function(e){

            e.preventDefault();

            var cnpj = $("input[name='cnpj']").val();

            var nome = $("input[name='nome']").val();

            $.ajax({

                url: "/cadastro/clinica",

                type:'POST',

                data: {cnpj:cnpj, nome:nome},

                success: function(data) {

                    if($.isEmptyObject(data.error)){

                        alert(data.success);

                    }else{

                        printErrorMsg(data.error);

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
    
</script>
@endsection
