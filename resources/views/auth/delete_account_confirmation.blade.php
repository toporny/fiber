@extends('layouts.app-master')

@section('content')
  <div class="bg-light p-5 rounded">
    @auth

    <h2 class="text-danger">Are you sure to delete your account?</h2>

    <p> All data connected with this account will be also deleted:</p>
    <ul>
      <li>{{$blowings_count}} blowings</li>
      <li>{{$clients_count}} clients</li>
    </ul>

    <h4 class="text-danger">This operation can not be undone.</h4>
    <form method="POST" action="{{ route('auth.deleteMyOwnAccountConfirmation') }}">
      @csrf
      <input type="submit" class="btn btn-danger btn btn-lg" value="{{ __('Delete') }}">
      <a class="m-3 btn btn-secondary btn btn-lg" href="/blowings/list" role="button">{{ __('Back') }}</a>
    </form>

    @endauth

  </div>
@endsection

