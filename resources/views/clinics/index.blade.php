@extends('layouts.app')

@section('content')
    <!-- Create Clinics Form... -->
    <div class="row">
        <div class="add-clinic align-button">
            <a class="font-weight-bold" href="{{ route('display_clinic_signup') }}"> 
                <button type="button" class="btn btn-primary">
                    <span class='glyphicon glyphicon-plus'></span> Cadastrar uma nova clínica 
                </button>
            </a>
        </div>
    </div>

    <!-- Current Clinics -->
    @if (count($clinics) > 0)

        <div class="panel panel-default">
            <div class="panel-heading">
                Clinicas cadastradas:
            </div>
            <div class="panel-body">
                <table class="table table-striped clinic-table">

                    <!-- Table Headings -->
                    <thead>
                        <th class="text-center"> Clínica</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($clinics as $clinic)
                            <tr>
                                <!-- Clinic Name -->
                                <td class="table-text text-center">
                                    <a href="{{ route('show_clinic', [$clinic->id]) }}">
                                        <div>{{ $clinic->nome }}</div>
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