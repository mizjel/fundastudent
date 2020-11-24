@extends('layouts.app')

@push('styles')

@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="section-block">
                    <h1>Doneren: {{ $academic_year->title }} </h1>

                    <form action="{{ route('donation.post', ['id' => $academic_year->id]) }}" method="post">
                    {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label class="control-label">Te doneren bedrag <span class="text-primary">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-eur" aria-hidden="true"></i></span>
                                <input id="amount" type="text"  class="form-control input-lg" name="amount" value="{{ old('amount', '5,00') }}" required/>
                            </div>
                            @if ($errors->has('amount'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="control-label">Emailadres <span class="text-primary">*</span></label>
                            <input id="email" type="email" class="form-control input" name="email" value="{{ old('email') }}" required/>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}" id="anonymous_name_input_view">
                            <label class="control-label">Naam</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"/>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('message') ? ' has-error' : '' }}">
                            <label class="control-label">Voeg een bericht toe aan je funding</label>
                            <textarea id="message" class="form-control" name="message" rows="3">{{ old('message') }}</textarea>
                            @if ($errors->has('message'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <hr>
                        <label id="label_total"></label><br>
                        <small>- Inclusief transactiekosten €{{ config('basics.transaction_costs') }}</small>

                        <div class="form-group"></div>

                        <button type="submit" name="submit" class="btn btn-primary btn-block">
                            Doneren
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var transaction_costs = '{{ config('basics.transaction_costs')  }}';
    </script>
    <script src="{{ mix('js/donation.js') }}"></script>
@endpush