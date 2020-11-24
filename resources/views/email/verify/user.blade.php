@extends('layouts.email')

@section('greeting')
    {{ trans('email.basics.greeting', ['name' => $user->getFullName()]) }}
@endsection

@section('message')
    Klik op de onderstaande knop om je account te verifiëren
@endsection

@section('buttons')
    @component('email.components.button')
        @slot('url')  {{ route('verify.user', ['token' => $user->email_token, 'email' => $user->email]) }}@endslot
        @slot('text') Account verifiëren @endslot
    @endcomponent
@endsection