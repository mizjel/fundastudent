@extends('layouts.dashboard')

@section('content')
    <h1>Mijn uitbetalingen</h1>

    @if($academicYears->isEmpty())
        Geen uitbetalingen gevonden
    @else
    <div class="section-block extra">
        <table class="table">
            <tr class="active">
                <th colspan="1"></th>
                <th>
                    Bedrag
                </th>
                <th>
                    Status
                </th>
            </tr>
            @foreach($academicYears as $academicYear)
                @foreach($academicYear->payouts->sortBy('academic_year_id') as $payout)
                    <tr>
                        <td>
                            <a href="{{ route('academic_years.show', $payout->academic_year->id) }}">{{ $payout->academic_year->title }}</a>
                        </td>
                        <td>
                            {{ $amountServiceClass->getReadableAmount($payout->amount) }}
                        </td>
                        <td>
                            {{ $payout->status->status }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>
    @endif
@endsection
