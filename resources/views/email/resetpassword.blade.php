@extends('layouts.email')

@section('greeting')

@endsection

@section('message')
    We hebben op dit e-mailadres een aanvraag ontvangen om het wachtwoord te wijzigen. <br>
    Klik op onderstaande knop om je wachtwoord te wijzigen
@endsection

@section('buttons')
    @component('email.components.button')
        @slot('url')  {{ route('password.reset.token', $token) }}@endslot
        @slot('text') Wachtwoord wijzigen @endslot
    @endcomponent
@endsection

