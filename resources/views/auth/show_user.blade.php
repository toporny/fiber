@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
            <table class="table table-hover">
                <thead>
                  <th>{{ __('Username') }}</th>
                  <th>{{ __('Email') }}</th>
                  <th class="text-center">{{ __('Created at') }}</th>
                  <th>{{ __('Action') }}</th>
                </thead>
                <tbody>
                    <tr>
                      <td class="align-middle" style="word-break: break-word;">{{$user->username}} </td>
                      <td class="align-middle" style="word-break: break-word;">{{$user->email}} </td>
                      <td class="text-center"><span style="white-space: nowrap;">{{ substr($user->created_at, 0, 10)}}</span><br>{{ substr($user->created_at, 11, 8)}}</td>
                      <td>
                        <a class="btn btn-success btn-sm mb-1" href="/profile/details" role="button">{{ __('View') }}</a>
                        <a class="btn btn-primary btn-sm mb-1" href="/profile/edit_by_user" role="button">{{ __('Edit') }}</a>
                        <a class="btn btn-secondary btn-sm mb-1" href="/blowings/list" role="button">{{ __('Blowings') }}</a>
                        <a class="btn btn-secondary btn-sm mb-1" href="/clients/list" role="button">{{ __('Clients') }}</a>
                        <a class="btn btn-warning btn-sm mb-1" href="/profile/change_password_by_user" role="button">{{ __('Change password') }}</a>
                      </td>
                    </tr>
            </table>
        @endauth

        @guest
        <h1>Homepage</h1>
        <p class="lead">
            {{ __('Your viewing the home page. Please login to view the restricted data.')}}
        </p>
        @endguest

            
    </div>
@endsection

