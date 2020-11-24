@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
        <div class="col-md-3">
            <div class="section-block">
                <h1>Sorteren</h1>
                <div class="section-block extra">
                    <form id="filter_form" method="GET" action="{{ route('home') }}">
                        <h2 class="clean-heading">Vakken</h2>
                        @foreach($enrollments as $enrollment)
                            <div class="checkbox">
                                <label><input type="checkbox" value="">{{ $enrollment->enrollment }}</label>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="section-block">
                <h1>Start met funden</h1>
                <div class="row nested-section-blocks">
                    @foreach($academicYears as $academicYear)
                        <div class="col-sm-6">
                            <div class="section-block extra href">
                                <a href="{{ route('academic_years.show', $academicYear->id) }}">
                                    <p>
                                        <span class="label label-primary"><i class="fa fa-calendar-check-o"></i> {{ $academicYear->academic_year_period->period }}</span>
                                        <span class="label label-primary"><i class="fa fa-user-circle"></i> {{ $academicYear->user->getFullName() }}</span>
                                    </p>
                                    <img class="static_img_set" src="{{ $academicYear->getThumbnail() }}" alt="{{ $academicYear->title }}">
                                    <div class="caption">
                                        <h4>{{ $academicYear->title }}</h4>
                                        <p>
                                            <b>{{ $amountServiceClass->getReadableAmount($academicYear->donations->where('paid', 1)->sum('amount')) }}</b>
                                            behaald van de
                                            <b>{{ $amountServiceClass->getReadableAmount($academicYear->goals->sum('amount')) }}</b>
                                        </p>
                                        <div class="progress nm">
                                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{ $academicYearServiceClass->getPercentageTotalPayments($academicYear) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $academicYearServiceClass->getPercentageTotalPayments($academicYear) }}%;">
                                                {{ $academicYearServiceClass->getPercentageTotalPayments($academicYear) }}%
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection

