@extends('layouts.app')

@push('scripts_head')
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
@endpush

@push('styles')

@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-block">
                    <h1>Campagne aanpassen</h1>

                    <form action="{{ route('academic_years.campaign.update', $academicYear) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="control-label">Titel <span class="text-primary">*</span></label>
                            <input type="text" name="title" class="form-control input-sm" value="{{ old('title', $academicYear->title) }}" required/>
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group {{ $errors->has('thumbnail_url') ? ' has-error' : '' }}">
                                    <label class="control-label">Afbeelding <span class="text-primary">*</span></label>
                                    <small class="help-block">Klik op de afbeelding om een afbeelding in te stellen</small>
                                    <label class="">
                                        <img src="{{ $academicYear->getThumbnail() }}" id="img_preview" class="img-responsive img-rounded "/>
                                        <input id="browse" name="thumbnail_url" type="file" style="display: none;">
                                    </label>
                                    @if ($errors->has('thumbnail_url'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('thumbnail_url') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-xs-12 col-sm-7 col-sm-push-1">
                                <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }}">
                                    <label class="control-label">Korte beschrijving <span class="text-primary">*</span></label>
                                    <textarea class="form-control input-sm" name="short_description" rows="5" required>{{ old('short_description', $academicYear->short_description) }}</textarea>
                                    @if ($errors->has('short_description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('short_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('full_description') ? ' has-error' : '' }}">
                            <label class="control-label">Uitgebreide beschrijving <span class="text-primary">*</span></label>
                            <textarea class="form-control input-sm" name="full_description" required>{{ old('full_description', $academicYear->full_description) }}</textarea>
                            @if ($errors->has('full_description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('full_description') }}</strong>
                                </span>
                            @endif
                            <script>
                                CKEDITOR.replace( 'full_description' );
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
    <script src="{{ mix('js/browse_image.js') }}"></script>
@endpush
