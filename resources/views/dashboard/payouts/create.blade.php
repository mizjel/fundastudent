@extends('layouts.dashboard')

@section('content')

<h1>Uitbetaling: <a href="{{ route('academic_years.show', $academicYear) }}">{{ $academicYear->title }}</a></h1>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="section-block extra">
        <table class="table table-bordered">
            <tr>
                <td>
                    Bruto gedoneerd
                </td>
                <td>
                    <b>{{ $amountServiceClass->getReadableAmount($academicYear->donations->where('paid', 1)->sum('amount')) }}</b>
                </td>
            </tr>

            <tr>
                <td>
                    Transactiekosten en inhoudingen
                </td>
                <td >
                    <b class="text-danger">- {{ $amountServiceClass->getReadableAmount($amountServiceClass->getAmountWithPercentage($academicYear->donations->where('paid', 1)->sum('amount'), 9)) }}</b>
                </td>
            </tr>

            <tr>
                <td>
                    Netto gedoneerd
                </td>
                <td class="text-success">
                    <b>{{ $amountServiceClass->getReadableAmount($amountServiceClass->getAmountWithPercentage($academicYear->donations->where('paid', 1)->sum('amount'), 91)) }}</b>
                </td>
            </tr>

            <tr>
                <td>
                    Reeds uitbetaald
                </td>
                <td >
                    <b>{{ $amountServiceClass->getReadableAmount($academicYear->payouts->where('status_id', '=', \App\Status::getStatusID(\App\Status::processed))->sum('amount')) }}</b>
                </td>
            </tr>

            <tr>
                <td>
                    Uitbetalingen in behandeling
                </td>
                <td >
                    <a href="{{ route('dashboard.payouts') }}"><b>{{ $academicYear->payouts->where('status_id', '=', \App\Status::getStatusID(\App\Status::in_progress))->count() }}</b></a>
                </td>
            </tr>

            <tr class="active">
                <th>
                    Beschikbaar saldo
                </th>
                <th class="text-success">
                    <b>{{ $amountServiceClass->getReadableAmount($amountServiceClass->getAmountWithPercentage($academicYear->donations->where('paid', 1)->sum('amount'), 91) - $academicYear->payouts->where('status_id', '!=', \App\Status::getStatusID(\App\Status::cancelled))->sum('amount')) }}</b>
                </th>
            </tr>
        </table>

            @include('flash::message')

            @if(Auth::user()->bank_account->status->hasStatus(\App\Status::verified))

            <form action="{{ route('dashboard.academic_years.payouts.store', $academicYear) }}" method="post">
                {{ csrf_field() }}

                <button class="btn btn-primary">Uitbetaling aanvragen</button>
            </form>

            @else

            <small class="text-danger">
                Je IBAN (bankrekeningnummer) is nog niet geverifieerd door Fund a Student.
                <br>
                Na registratie van je IBAN duurt het gemiddeld 1 dag voordat je bankrekening is geverifieerd.
                <br>
                Zodra dit is gebeurd kan je een betaling aanvragen
            </small>

            @endif
        </div>
    </div>
</div>
@endsection
