@extends('layouts.app')

@section('content')
    <!-- Create Clinics Form... -->

    <!-- Current Clinics -->
    @if (count($clinics) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Clinics
            </div>

            <div class="panel-body">
                <table class="table table-striped clinic-table">

                    <!-- Table Headings -->
                    <thead>
                        <th> Clinic</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($clinics as $clinic)
                            <tr>
                                <!-- Clinic Name -->
                                <td class="table-text">
                                    <div>{{ $clinic->nome }}</div>
                                </td>

                                <td>
                                    <!-- TODO: Delete Button -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection