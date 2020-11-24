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
                    <h1>Update maken</h1>

                    <form action="{{ route('academic_years.updates.store', $academicYear) }}" method="post">
                    {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="control-label">Titel</label>
                            <input type="text" name="title" class="form-control input-sm" value="{{ old('title') }}" required/>
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('update') ? ' has-error' : '' }}">
                            <label class="control-label">Update</label>
                            <textarea class="form-control input-sm" name="update" rows="5" required>{{ old('update') }}</textarea>
                            @if ($errors->has('update'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('update') }}</strong>
                                </span>
                            @endif
                            <script>
                                CKEDITOR.replace( 'update' );
                            </script>
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
