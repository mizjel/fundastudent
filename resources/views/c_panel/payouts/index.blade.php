@extends('layouts.c_panel')

@section('content')
    <h1>Uitbetalingen</h1>

    @if($payouts->isEmpty())
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
                    @foreach($payouts->sortBy('created_at') as $payout)
                        <tr>
                            <td>
                                <a href="{{ route('academic_years.show', $payout->academic_year->id) }}">{{ $payout->academic_year->title }}</a>
                            </td>
                            <td>
                                {{ $amountServiceClass->getReadableAmount($payout->amount) }}
                            </td>
                            <td>
                                <form action="{{ route('c_panel.payouts.change_status', ['payout_id' => $payout->id]) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <select class="form-control" onchange="this.form.submit()" name="status_id">
                                        @foreach([\App\Status::in_progress, \App\Status::processed, \App\Status::cancelled] as $status)
                                            <option {{ $payout->status->hasStatus($status) ? 'selected' : '' }} value="{{ \App\Status::getStatusID($status) }}">{{ \App\Status::$statuses[$status] }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
            </table>
        </div>
    @endif
@endsection
