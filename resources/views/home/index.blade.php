@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">

        @if (\Session::has('error'))
            <div class="alert alert-danger">
                <ul>
                    <li>{!! \Session::get('error') !!}</li>
                </ul>
            </div>
        @endif

        @auth
        <h1>Dashboard</h1>
        <p class="lead">{{ __('Only authenticated users can access this section.')}}</p>
        <a class="btn btn-lg btn-primary" href="https://codeanddeploy.com" role="button">View more tutorials here &raquo;</a>
        @endauth

        @guest
        <h1>Homepage</h1>
        <p class="lead">
            {{ __('Your viewing the home page. Please login to view the restricted data.')}}
        </p>
        @endguest


            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                {{ __('Welcome to our website') }}
            </div>

            
    </div>
@endsection
