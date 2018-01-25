@extends('layouts.app')

@section('content')
    <!-- Create health_insurance_companies Form... -->

    <!-- Current health_insurance_companies -->
    @if (count($health_insurance_companies) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Planos de Saúde cadastrados:
            </div>

            <div class="panel-body">
                <table class="table table-striped health_insurance_company-table">

                    <!-- Table Headings -->
                    <thead>
                        <th> Planos de saúde</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($health_insurance_companies as $health_insurance_company)
                            <tr>
                                <!-- Health Insurance Company Name -->
                                    <td class="table-text">
                                        <a href="{{ route('show-health_insurance_company', [$health_insurance_company->id]) }}">
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