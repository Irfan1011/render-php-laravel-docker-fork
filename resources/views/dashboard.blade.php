@extends('content')

<nav class="navbar navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold">Atma Jogja Rental</a>
        <div class="d-flex justify-content-end">
            @if (Route::has('login'))
                <div class="hidden fixed sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                    @else
                    @if (Route::has('register'))
                    <a class="btn btn-outline-dark me-2" href="{{route('register')}}" role="button">Sign Up</a>
                    @endif
                    <a class="btn btn-outline-dark me-2" href="{{route('login')}}" role="button">Login</a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
</nav>

<div class="bg">
    <div class="container min-vh-100 align-items-center">
        @if($message=Session::get('success'))
        <div class="alert text-center fw-bold" style="padding-top:65px; color:ffffff; text-shadow: 2px 2px #FF0000;">
            <p>{{$message}}</p>
        </div>
        @endif
        <h2 class="position-absolute top-50 start-50 translate-middle"><b>Welcome to Atma Jogja Rental</b></h2>

        <div class="position-absolute bottom-0 start-0">
            <img class="h-25 d-inline-block" style="width: 80px;"
                src="{{ asset('uploads/AJR Logo.png') }}" alt="AJR Logo">
        </div>
    </div>
</div>