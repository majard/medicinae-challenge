@extends('layouts.app')

@section('content')

<div class="panel panel-default">

    <div class="panel-body">
        <table class="table table-striped clinic-table">


            <!-- Table Body -->
            <tbody>
                <tr>
                    <td>
                        Nome da Clínica
                    </td>
                    <td>
                        CNPJ
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <!-- Clinic Name -->
                    <td class="table-text">
                        <div>{{ $clinic->nome }}</div>
                    </td>
                    <td class="table-text">
                        <div>{{ $clinic->cnpj }}</div>
                    </td>                            
                    
                    <td>                        
                        <button type="button" class="btn btn-danger delete-modal" value="{{$clinic->id}}" data-dismiss="modal">
                            <span class='glyphicon glyphicon-trash'></span> Deletar
                        </button>      
                        <button class="clinic btn btn-edit edit-modal" data-nome="{{$clinic->nome}}" data-cnpj="{{$clinic->cnpj}}" value="{{$clinic->id}}">
                        <span class="glyphicon glyphicon-edit"></span> Editar
                        </button>
                 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    
    <!-- Current Health Insurance Companies Accepted -->
    @if ((count($clinic->health_insurance_companies) > 0) && (($clinic->user_id == Auth::user()->id)))

        <div class="panel panel-default">
            <div class="panel-heading">
                Planos de saúde aceitos:
            </div>
            <div class="panel-body">
                <table class="table table-striped clinic-table">

                    <!-- Table Headings -->
                    <thead>
                        <th class="text-center"> Plano de saude</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($clinic->health_insurance_companies as $health_insurance_company)
                        <tr>
                            <td class="table-text">
                                <div> <img src="{{ Storage::url($health_insurance_company->logo) }}"> </div>
                            </td>
                            <!-- Health Insurance Company Name -->
                            <td class="table-text">
                                <a href="{{ route('show_health_insurance_company', [$health_insurance_company->id]) }}">
                                    <div>{{ $health_insurance_company->nome }}</div>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endif
    
    <!-- Modal form to edit a form -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nome">Nome da Clinica:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nome_edit">
                                <p class="errorNome text-center alert alert-danger hidden"></p>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="cnpj">CNPJ:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="cnpj_edit" autofocus>
                                <p class="errorCnpj text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary clinic edit">
                            <span class='glyphicon glyphicon-check'></span> Edit
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <!-- Modal form to delete a form -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Tem certeza que deseja deletar essa clinica?</h3>
                    <br />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger clinic delete" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-trash'></span> Deletar
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection