@extends('layouts.app')

@push('scripts_head')
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
@endpush

@push('styles')

@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="section-block">
                    <h1>Doel updaten</h1>

                    <form action="{{ route('academic_years.goals.update', [$academicYear, $academicYearGoal]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label class="control-label">Doel beschrijving <span class="text-primary">*</span></label>
                            <input type="text" name="description" class="form-control input-sm" value="{{ old('description', $academicYearGoal->description) }}" required/>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label class="control-label">Benodigd bedrag <span class="text-primary">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-eur" aria-hidden="true"></i></span>
                                <input id="amount" type="text"  class="form-control input-sm" name="amount" value="{{ old('amount', $amountServiceClass->getValidAmountForInput($academicYearGoal->amount)) }}" required/>
                            </div>
                            @if ($errors->has('amount'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Opslaan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
