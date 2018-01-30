@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="add-hic align-button">
            <a  href="{{ route('display_health_insurance_company_signup') }}"> 
                <button type="button" class="btn btn-primary">
                    <span class='glyphicon glyphicon-plus'></span> Cadastrar um novo plano de saúde
                </button>
            </a>
        </div>
    </div>

    <!-- Current health_insurance_companies -->
    @if (count($health_insurance_companies) > 0)
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-striped health_insurance_company-table">

                    <!-- Table Headings -->
                    <thead>
                        <th> Planos de saúde</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                            <tr>
                                <td> Logo </td>
                                <td> Nome </td>
                            </tr>
                        @foreach ($health_insurance_companies as $health_insurance_company)
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
@endsection