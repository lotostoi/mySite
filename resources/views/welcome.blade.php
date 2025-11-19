@extends('layouts.app')

@section('title', 'Александр - Психолог во Владивостоке | Консультации онлайн и очно')

@section('content')
    @include('components.header')

    <main>
        @include('components.hero')

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24">
            @include('components.about')
            @include('components.services')
            @include('components.contact')
        </div>
    </main>

    @include('components.footer')
@endsection
