@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">

        <!-- New health_insurance_company Form -->
        <form enctype="multipart/form-data" id="upload_form" action="" class="form-horizontal">
            {{ csrf_field() }}

            <!-- health_insurance_company Info -->
            <div class="form-group">

                <div class="row">
                    <label for="health_insurance_company-name" class="col-sm-3 control-label">Nome do Plano de Saúde</label>

                    <div class="col-sm-6">
                        <input type="text" name="nome" id="health_insurance_company-name" class="form-control">
                        <p class="errorNome text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="row">
                    <label for="" class="col-sm-3 control-label">Logo</label>

                    <div class="col-sm-6">
                        <input type="file" name="image" class="form-control">
                        <p class="errorImage text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="row">
                    <label for="" class="col-sm-3 control-label">Ativo</label>

                    <div class="col-sm-6">
                        <input type="checkbox" name="status" class="form-control">
                        <p class="errorStatus text-center alert alert-danger hidden"></p>
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
