@extends('layouts.app')

@section('content')

<div class="panel panel-default">

    <div class="panel-body">
        <table class="table table-striped health_insurance_company-table">


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
                    <!-- Health Insurance Company Name -->
                    <td class="table-text">
                        <div>{{ $health_insurance_company->nome }}</div>
                    </td>
                    <td class="table-text">
                        <div>{{ $health_insurance_company->status }}</div>
                    </td>                            
                    <td class="table-text">
                        <div> <img src="{{ $logo_url }}"> </div>
                    </td>                            
                    
                    <td>                        
                        <button type="button" class="btn btn-danger health_insurance delete-modal" value="{{$health_insurance_company->id}}" data-dismiss="modal">
                            <span class='glyphicon glyphicon-trash'></span> Deletar
                        </button>      
                        <button class="health-insurance edit-modal btn btn-edit" data-nome="{{$health_insurance_company->nome}}" 
                        data-status="{{$health_insurance_company->status}}" value="{{$health_insurance_company->id}}">
                        <span class="glyphicon glyphicon-edit"></span> Editar
                        </button>
                 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    
    <!-- Modal form to edit a form -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="upload_form" action="" class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nome">Nome do Plano de Saúde:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nome" id="nome_edit">
                            </div>
                        </div>                        
                        <div class="form-group">
                            <img src="{{ $logo_url }}"> 
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="logo">Logo:</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="image" id="logo_edit" autofocus>
                                <p class="errorTitle text-center alert alert-danger hidden"></p>
                            </div>
                        </div>               
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="status">Status:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="status" id="status_edit" autofocus>
                                <p class="errorTitle text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary health_insurance edit" data-dismiss="modal">
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
                    <h3 class="text-center">Tem certeza que deseja deletar esse plano de saúde?</h3>
                    <br />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger health_insurance delete" data-dismiss="modal">
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