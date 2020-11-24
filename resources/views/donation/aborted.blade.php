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
                            <img class="img-rounded" style="width:100%;" src="{{ url('extra-resources/aborted.gif') }}"/>
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
                        </div>

                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a class="btn btn-primary btn-block" href="{{ route('home') }}">Terug naar thuis pagina</a>
                                </div>
                                <div class="col-xs-6">
                                    <a class="btn btn-primary btn-block" href="{{ route('donation.get', ['id' => $donation->academic_year->id]) }}">Probeer het opnieuw</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush