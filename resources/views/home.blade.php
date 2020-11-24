@extends('layouts.app')

@section('content')
    <header class="header-image form-group">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="headline">
                        <div class="section-block">
                            <div class="section-block extra">
                                <h1>Fund a Student.nl</h1>
                            </div>
                            <h2>Crowdfunding voor studenten</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-block">
                    <h1>Populaire studies</h1>
                        <div class="row nested-section-blocks">
                            @foreach($academicYears as $academicYear)
                                <div class="col-md-4">
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
