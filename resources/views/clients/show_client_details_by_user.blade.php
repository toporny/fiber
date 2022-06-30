@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth

@if(session()->has('error'))
    <div class="alert alert-danger">
        <strong>{{ session()->get('error') }}</strong>
    </div>
@endif
@if(session()->has('success'))
    <div class="alert alert-success">
        <strong>{{ session()->get('success') }}</strong>
    </div>
@endif


<h2>Show client details</h2>

<div class="container g-0">
  <h5 class="mt-4 mb-0">Client</h5>
  <div class="row mt-1">
    <div class="text-black-50 text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      client_name:
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
        {{$blowing->client_name}}
    </div>

    <div class="text-black-50 text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      client_nip:
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        {{$blowing->client_nip}}
    </div>
  </div>

  <div class="row mt-1">
    <div class="text-black-50 text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      client_address:
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        {{$blowing->client_address}}
    </div>
  </div>

  <div class="container g-0 mt-4">
    <a class="btn btn-success btn btn-lg" href="/profile/blowing/edit/{{$blowing->id}}" role="button">{{ __('Edit') }}</a>
    <a class="m-3 btn btn-secondary btn btn-lg" href="/blowing/show_source/{{$blowing->id}}" role="button">{{ __('Source data') }}</a>
    <a class="btn btn-danger btn btn-lg" href="/blowing/delete/{{$blowing->id}}" role="button">{{ __('Delete') }}</a>
    <a class="m-3 btn btn-primary btn btn-lg" href="/blowings/list" role="button">{{ __('Back') }}</a>
  </div>
  @endauth
</div>
@endsection

