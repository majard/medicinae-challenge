@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Clinic Form -->
        <form class="form-horizontal">
            {{ csrf_field() }}

            <!-- Clinic Info -->
            <div class="form-group">
                <div class="row">
                    <label for="cnpj" class="col-sm-3 control-label">CNPJ</label>

                    <div class="col-sm-6">
                        <input type="text" name="cnpj" id="clinic-cnpj" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <label for="clinic-name" class="col-sm-3 control-label">Nome da Clínica</label>

                    <div class="col-sm-6">
                        <input type="text" name="nome" id="clinic-name" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Add Clinic Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="button" class="btn btn-default create-clinic">
                        <i class="fa fa-plus"></i> Add Clinic
                    </button>
                </div>
            </div>
        </form>
    </div>
    
@endsection
