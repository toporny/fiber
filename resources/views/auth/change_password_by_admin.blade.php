@extends('layouts.app-master')

@section('content')
        <div class="col-md-8">
            <h4 class="mt-3 mb-3">Change password for: {{$username}} ({{$email}})</h4>
            <div class="card">
                @if(session()->has('error'))
                    <span class="alert alert-danger">
                        <strong>{{ session()->get('error') }}</strong>
                    </span>
                @endif
                @if(session()->has('success'))
                    <span class="alert alert-success">
                        <strong>{{ session()->get('success') }}</strong>
                    </span>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('auth.changepasswordbyadmin') }}">
                        @csrf

                        <div class="form-group row mt-2 mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="password">
                                @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <input type="hidden"  name="user_id" value="{{$id}}">
                                <button type="submit" class="btn btn-danger">
                                    Change Password
                                </button>

                                <a class="btn btn-primary btn m-2" href="/profile" role="button">{{ __('Back to profile') }}</a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection