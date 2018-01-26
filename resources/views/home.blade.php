@extends('layouts.app')

@section('content')

    <div class="flex-center position-ref full-height">

        <div class="content">
            <div class="title m-b-md">
                Medicinae
            </div>

            <div class="links">
                <a href="{{ route('clinics') }}">Clínicas</a>
                <a href="{{ route('health_insurance_companies') }}">Planos de Saúde</a>
            </div>
        </div>
    </div>

@endsection

