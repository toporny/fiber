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

    <h2>Edit client</h2>


    <form method="POST" enctype="multipart/form-data" action="{{ $action }}">

      @csrf

      <div class="container g-0">
        <div class="row mt-1">
          <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
            client_name
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
              <input type="text" maxlength="50" class="form-control @error('client_name') is-invalid @enderror" name="client_name" autocomplete="client_name" value="{{$client->client_name}}">
              @error('client_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('client_name') }}</strong>
                </span>
              @enderror
          </div>
        </div>

        <div class="row mt-1">
          <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
            client_address
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
              <input type="text" maxlength="50" class="form-control @error('client_address') is-invalid @enderror" name="client_address" autocomplete="client_address" value="{{$client->client_address}}">
                  @error('client_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('client_address') }}</strong>
                    </span>
                  @enderror
          </div>
        </div>

        <div class="row mt-1">
          <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
            client_nip
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
              <input type="text" maxlength="50" class="form-control @error('client_nip') is-invalid @enderror" name="client_nip" autocomplete="client_nip" value="{{$client->client_nip}}">
                  @error('client_nip')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('client_nip') }}</strong>
                    </span>
                  @enderror
          </div>
        </div>

        <div class="container g-0 mt-4">
            <input type="hidden" name="client_id" value="{{$client->id}}"></button>
            <button class="btn btn-lg btn-primary" type="submit">Submit</button>
            <a class="btn btn-lg m-2 btn-secondary" href="/clients/list" role="button">{{ __('Back') }}</a>
        </div>

        
      </div>
    </form>

  @endauth

  </div>
@endsection

