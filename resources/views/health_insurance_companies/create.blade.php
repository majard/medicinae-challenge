@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New health_insurance_company Form -->
        <form enctype="multipart/form-data" id="upload_form" action="" class="form-horizontal">
            {{ csrf_field() }}

            <!-- health_insurance_company Info -->
            <div class="form-group">

                <div class="row">
                    <label for="health_insurance_company-name" class="col-sm-3 control-label">Nome do Plano de Saúde</label>

                    <div class="col-sm-6">
                        <input type="text" name="nome" id="health_insurance_company-name" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <label for="" class="col-sm-3 control-label">Logo</label>

                    <div class="col-sm-6">
                        <input type="file" name="image" class="form-control">
                    </div>

                </div>
            </div>

            <!-- Add health_insurance_company Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="button" class="btn btn-default create-health_insurance_company">
                        <i class="fa fa-plus"></i> Adicionar Plano de Saúde
                    </button>
                </div>
            </div>
        </form>
    </div>
    
@endsection
