@extends('layouts.dashboard')

@section('content')
    <h1>Mijn geverifieerde studiejaren</h1>
    @if($academicYears->isEmpty())
        Geen studiejaren gevonden
    @else
    <div class="row nested-section-blocks">
        @foreach($academicYears as $academicYear)
            <div class="col-sm-4">
                <div class="section-block extra href">
                    <a href="{{ route('academic_years.show', $academicYear->id) }}">
                        <p><span class="label label-primary"><i class="fa fa-calendar-check-o"></i> {{ $academicYear->academic_year_period->period }}</span></p>
                        <img class="static_img_set" src="{{ $academicYear->getThumbnail() }}" alt="{{ $academicYear->title }}">
                        <div class="caption">
                            <h4>{{ $academicYear->title }}</h4>
                            <p>
                                <b>{{ $amountServiceClass->getReadableAmount($academicYear->donations->where('paid', 1)->sum('amount')) }}</b>
                                behaald van de
                                <b>{{ $amountServiceClass->getReadableAmount($academicYear->goals->sum('amount')) }}</b>
                            </p>
                            <div class="progress form-group">
                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{ $academicYearServiceClass->getPercentageTotalPayments($academicYear) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $academicYearServiceClass->getPercentageTotalPayments($academicYear) }}%;">
                                    {{ $academicYearServiceClass->getPercentageTotalPayments($academicYear) }}%
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <a href="{{ route('dashboard.academic_years.payouts.create', $academicYear) }}" class="btn btn-primary btn-sm" role="button"><i class="fa fa-money" aria-hidden="true"></i> Uitbetalen</a>
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
