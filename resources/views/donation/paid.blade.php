@extends('layouts.app')

@push('styles')

@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="section-block">
                    <h1>Bedankt voor je donatie</h1>

                    <div class="row">
                        <div class="col-sm-4 col-xs-12 form-group">
                            <img class="img-rounded" style="width:100%;" src="{{ url('extra-resources/paid.gif') }}"/>
                        </div>
                        <div class="col-sm-8 col-xs-12 form-group">
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td><b>Begunstigde</b></td>
                                    <td><a href="{{ route('academic_years.show', $donation->academic_year->id) }}">{{ $donation->academic_year->user->getFullName() }}</a></td>
                                </tr>
                                <tr>
                                    <td><b>Bedrag</b></td>
                                    <td>{{ $amount }}</td>
                                </tr>
                                <tr>
                                    <td><b>Status</b></td>
                                    <td>{{ $donation->getStatus() }}</td>
                                </tr>
                            </table>
                            @if($donation->paid != 1)
                                <small>Je ontvangt een email op <b>{{ $donation->email }}</b> zodra de betaling volledig is verwerkt.</small>
                            @endif
                        </div>

                        <div class="col-xs-12">
                            <a class="btn btn-primary btn-block" href="{{ route('home') }}">Terug naar thuis pagina</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush