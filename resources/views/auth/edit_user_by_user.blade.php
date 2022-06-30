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

<h2>Edit user by user ({{$user_to_edit->username}})</h2>

<img src="/uploads/{{$user_to_edit->image}}">

<form method="POST" enctype="multipart/form-data" action="{{ route('auth.ChangUserByUser') }}">
    @csrf

    <table class="table table-striped">
        <tr>
            <td>company_name</td><td>
            <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" autocomplete="company_name" value="{{$user_to_edit->company_name}}">
            @error('company_name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('company_name') }}</strong>
              </span>
            @enderror
            </td>
        </tr>
        
        <tr>
            <td>company_address</td><td>
            <input type="text" class="form-control @error('company_address') is-invalid @enderror" name="company_address" autocomplete="company_address" value="{{$user_to_edit->company_address}}">
            @error('company_address')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('company_address') }}</strong>
              </span>
            @enderror
            </td>
        </tr>
        

        <tr>
            <td>company_tax_number</td><td>
            <input type="text" class="form-control @error('company_tax_number') is-invalid @enderror" name="company_tax_number" autocomplete="company_tax_number" value="{{$user_to_edit->company_tax_number}}">
            @error('company_tax_number')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('company_tax_number') }}</strong>
              </span>
            @enderror
            </td>
        </tr>


        <tr>
            <td>company_phone</td><td>
            <input type="text" class="form-control @error('company_phone') is-invalid @enderror" name="company_phone" autocomplete="company_phone" value="{{$user_to_edit->company_phone}}">
            @error('company_phone')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('company_phone') }}</strong>
              </span>
            @enderror
            </td>
        </tr>


        <tr><td>your logo</td><td>
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
            @error('image')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('image') }}</strong>
              </span>
            @enderror
            </td>
        </tr>


        <tr><td>email</td><td>
            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="email" value="{{$user_to_edit->email}}">
            @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
            @enderror
            </td>
        </tr>
    </table>

    <button class="btn btn-lg btn-primary" type="submit">Submit</button>
    <a class="btn btn-lg m-2 btn-secondary" href="/profile" role="button">{{ __('Back') }}</a>
    <p class="text-end">
        <a class="btn btn-lg m-2 btn-danger" href="{{ route('auth.deleteMyOwnAccountConfirmation') }}" role="button">{{ __('Delete Account') }}</a>
    </p>

</form>


        @endauth

        
    </div>
@endsection

