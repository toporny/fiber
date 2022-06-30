@extends('layouts.app-master')

@section('content')
  <div class="bg-light p-5 rounded">
    @auth

    <h2 class="text-danger">Are you sure to delete this record?</h2>

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
        <div class="text-black-50 text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
          language:
        </div>
        <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            {{$blowing->language}}
        </div>
    </div>


    <div class="container g-0">
      <h5 class="mt-4 mb-0">Route</h5>
      <div class="row mt-1">
        <div class="text-black-50 text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
          route_name:
        </div>
        <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            {{$blowing->route_name}}
        </div>
        <div class="text-black-50 text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
          route_start:
        </div>
        <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
            {{$blowing->route_start}}
        </div>
      </div>

      <div class="row mt-1">
        <div class="text-black-50 text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
          route_end:
        </div>
        <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            {{$blowing->route_end}}
        </div>
        <div class="text-black-50 text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
          operator:
        </div>
        <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
            {{$blowing->operator}}
        </div>
      </div>



      <div class="row mt-1">
        <div class="text-black-50 text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
          city:
        </div>
        <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            {{$blowing->city}}
        </div>
      </div>
    </div>


    <form method="POST" action="/blowing/delete">
      @csrf
      <input type="hidden" name="blowing_id" value="{{$blowing->id}}">
      <input type="submit" class="btn btn-danger btn btn-lg" value="{{ __('Delete') }}">
      <a class="m-3 btn btn-success btn btn-lg" href="/blowings/list" role="button">{{ __('Back') }}</a>
    </form>

    @endauth

  </div>
@endsection

