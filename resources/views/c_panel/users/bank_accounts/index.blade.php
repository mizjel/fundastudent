@extends('layouts.c_panel')

@section('content')
    <h1>Bank Accounts</h1>

    @if($bankAccounts->isEmpty())
        Geen bank accounts gevonden
    @else
        <div class="section-block extra">
            <table class="table">
                <tr class="active">
                    <th>
                        #Gebruiker
                    </th>
                    <th>
                        IBAN
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Acties
                    </th>
                </tr>
                @foreach($bankAccounts->sortBy('created_at') as $bankAccount)
                    <tr>
                        <td>
                            {{ $bankAccount->user->getFullName() }}
                        </td>
                        <td>
                            {{ $bankAccount->iban }}
                        </td>
                        <td>
                            {{ $bankAccount->status->status }}
                        </td>
                        <td>
                            @if($bankAccount->status->hasStatus(\App\Status::unverified))
                                <form id="change-status-verified-form" action="{{ route('c_panel.users.bank_accounts.change_status', ['user_id' => $bankAccount->user_id]) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input hidden name="status_id" value="{{ \App\Status::getStatusID(\App\Status::verified) }}"/>
                                    <button type="submit" class="btn btn-primary btn-sm">Verifieeren</button>
                                </form>
                            @else
                                <form id="change-status-unverified-form" action="{{ route('c_panel.users.bank_accounts.change_status', ['user_id' => $bankAccount->user_id]) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input hidden name="status_id" value="{{ \App\Status::getStatusID(\App\Status::unverified) }}"/>
                                    <button type="submit" class="btn btn-primary btn-sm">Ongedaan maken</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

@endsection
