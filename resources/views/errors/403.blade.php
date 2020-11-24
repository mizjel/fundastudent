@extends('layouts.app')

@push('styles')

@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="section-block">
                <h1>Oopsie een 403: Je bent niet bevoegd voor deze pagina</h1>
                <a href="{{ route('home') }}" class="btn btn-primary "><i class="fa fa-building-o"></i> ga terug naar thuis pagina</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
