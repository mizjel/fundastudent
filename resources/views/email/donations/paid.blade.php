@extends('layouts.email')

@section('greeting')
    {{  trans('email.basics.greeting', ['name' => $donation->getName()]) }}
@endsection

@section('message')
    {!!  trans('email.donation.paid.message', ['amount' => $amount, 'student' => $donation->academic_year->user->getFullName()]) !!}
@endsection

{{--@section('buttons')--}}
    {{--@component('email.components.button')--}}
        {{--@slot('url')  {{ $content['btn_url'] }}@endslot--}}
        {{--@slot('text') {{ $content['btn_text'] }}@endslot--}}
    {{--@endcomponent--}}
{{--@endsection--}}