@extends('layouts.dashboard')

@section('content')
    <h1>Niet geverifieerde studiejaren</h1>
    @if($academicYears->isEmpty())
        Geen studiejaren gevonden
    @else
    <div class="row nested-section-blocks">
        @foreach($academicYears as $academicYear)
            <div class="col-sm-6 col-md-4">
                <div class="section-block extra href">
                    <a href="{{ route('academic_years.show', $academicYear->id) }}">
                        <p><span class="label label-primary"><i class="fa fa-calendar-times-o"></i> {{ $academicYear->academic_year_period->period }}</span></p>
                        <img class="static_img_set" src="{{ $academicYear->getThumbnail() }}" alt="{{ $academicYear->title }}">
                        <div class="caption">
                            <h4>{{ $academicYear->title }}</h4>
                            <div class="row">
                                <div class="col-xs-12">
                                    <a href="{{ route('verify.academic_year.resend', ['token' => $academicYear->email_token, 'email' => $academicYear->email]) }}" class="btn btn-primary btn-sm"  title="Verstuur verificatie mail naar {{ $academicYear->email }}">Verifieer <i class="fa fa-envelope" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    @endif
@endsection
