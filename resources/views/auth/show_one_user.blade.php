@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth

<h2>User details</h2>

<img src="/uploads/{{$user->image}}" width="300px; height:auto;">

<table class="table table-striped">
    @if (auth()->user()->is_admin)
        <tr><td>id</td><td>{{$user->id}}</td>
    @endif
    <tr><td>company_name</td><td>{{$user->company_name}}</td>
    <tr><td>company_address</td><td>{{$user->company_address}}</td>
    <tr><td>company_tax_number</td><td>{{$user->company_tax_number}}</td>
    <tr><td>company_phone</td><td>{{$user->company_phone}}</td>
    <tr><td>email</td><td>{{$user->email}}</td>
    <tr><td>username</td><td>{{$user->username}}</td>
    @if (auth()->user()->is_admin)
    <tr><td>is_admin</td><td>{{$user->is_admin}}</td>
    <tr><td>email_verified_at</td><td>{{$user->email_verified_at}}</td>
    <tr><td>remember_token</td><td>{{$user->remember_token}}</td>
    @endif
    <tr><td>created_at</td><td>{{$user->created_at}}</td>
    <tr><td>updated_at</td><td>{{$user->updated_at}}</td>
</table>



	@if (auth()->user()->is_admin)
        <a class="btn btn-success btn" href="/profile/edit_profile_by_admin/{{$user->id}}" role="button">{{ __('Edit') }}</a>
	    <a class="btn btn-warning btn" href="/profile/change_password_by_admin/{{$user->id}}" role="button">{{ __('Change password') }}</a>
	@else
        <a class="btn btn-success btn" href="/profile/edit_by_user" role="button">{{ __('Edit') }}</a>
	    <a class="btn btn-warning btn" href="/profile/change_password_by_user" role="button">{{ __('Change password') }}</a>
	@endif


    <a class="btn btn-primary btn" href="/profile" role="button">{{ __('Back to profile') }}</a>

        @endauth

        
    </div>
@endsection

