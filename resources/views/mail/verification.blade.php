@extends('mail.layout')
@section('content')
    <!-- Logo Section -->
    <x-mail-logo></x-mail-logo>
    <!-- First Email Image-->
    <x-mail-banner imageLink="https://imagizer.imageshack.com/img923/2884/D2siXj.png"></x-mail-banner>
    <!-- Welcome To Qrate section -->
    <x-welcome-section heading="Hey {{$username}}">
        Glad to have you join us. We hope you get to enjoy using Qrate! To verify your email, kindly click below
    </x-welcome-section>
    <!-- Explore Button -->
    <x-mail-button url="{!!$url!!}">
        Proceed
    </x-mail-button>

    <p> copy  link if you can't click on the button above {{$url}} </p>
    <p> Ignore this if you didn't register to this platform</p>
@endsection
