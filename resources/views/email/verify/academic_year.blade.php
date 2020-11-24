@extends('layouts.email')

@section('greeting')
    {{ trans('email.basics.greeting', ['name' => $academicYear->user->getFullName()]) }}
@endsection

@section('message')
    Klik op de onderstaande knop om je schooljaar te verifiëren
@endsection

@section('buttons')
    @component('email.components.button')
        @slot('url')  {{ route('verify.academic_year', ['token' => $academicYear->email_token, 'email' => $academicYear->email]) }}@endslot
        @slot('text') Schooljaar verifiëren @endslot
    @endcomponent
@endsection