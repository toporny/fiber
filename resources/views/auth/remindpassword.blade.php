@extends('layouts.auth-master')

@section('content')
    <form method="post" action="{{ route('auth.remind_password') }}">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        
        <h1 class="h3 mb-4 fw-normal">{{ __('Remind password') }}</h1>

        @include('layouts.partials.messages')

        <div class="form-group form-floating mb-4">
            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
            <label for="floatingName">{{ __('Email or Username') }}</label>
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
        </div>
        
        <button class="w-100 mb-4 btn btn-lg btn-primary" type="submit">{{ __('Remind password') }}</button>

        <p><a href="/" >{{ __('Back') }}</a></p>
        
        @include('auth.partials.copy')
    </form>
@endsection
