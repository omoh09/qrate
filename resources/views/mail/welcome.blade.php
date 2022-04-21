@extends('mail.layout')
@section('content')
    <!-- Logo Section -->
    <x-mail-logo></x-mail-logo>
    <!-- First Email Image-->
    <x-mail-banner imageLink="https://qrateart.com/images/emailBanner.png"></x-mail-banner>
    <!-- Welcome To Qrate section -->
    <x-welcome-section heading="Welcome to Qrate!">
        Thanks for Registering on the platform, we look forward to giving you the best experience you could get regarding art
    </x-welcome-section>
    <!-- Explore Button -->
    <x-mail-button url="{!! $url !!}">
        Explore!
    </x-mail-button>
    <!-- Second Email Image -->
    <x-mail-banner2 imageUrl="https://qrateart.com/images/MacBook.png"></x-mail-banner2>
    <!-- Subscribe to newsletter section -->
    <x-welcome-section heading="Subscribe to NewsLetter!">
        To get notification about various events and exhibition you could subscribe
    </x-welcome-section>
    <!-- Subscribe Button-->
    <x-mail-button url="lovely">
        Subscribe
    </x-mail-button>
@endsection
