@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-3 rounded">
        @auth
            <table class="table table-hover">
                <thead>
                  <th>{{ __('Username') }}</th>
                  <th>{{ __('Email') }}</th>
                  <th class="text-center">{{ __('Created at') }}</th>
                  <th>{{ __('Action') }}</th>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>


                      <td class="align-middle {{($user->is_admin == '1') ? ' text-danger' : ''}}" style="word-break: break-word;">{{$user->username}} </td>
                      <td class="align-middle" style="word-break: break-word;">{{$user->email}} </td>
                      <td class="text-center"><span style="white-space: nowrap;">{{ substr($user->created_at, 0, 10)}}</span><br>{{ substr($user->created_at, 11, 8)}}</td>
                      <td class="align-middle">
                        <a class="btn btn-success btn-sm mb-1" href="/profile/details/{{$user->id}}" role="button">{{ __('View') }}</a>
                        <a class="btn btn-primary btn-sm mb-1" href="/profile/edit_profile_by_admin/{{$user->id}}" role="button">{{ __('Edit') }}</a>
                        <a class="btn btn-secondary btn-sm mb-1" href="/profile/blowings/{{$user->id}}" role="button">{{ __('Blowings') }} ({{$user->c}}) </a>
                        <a class="btn btn-warning btn-sm mb-1" href="/profile/change_password_by_admin/{{$user->id}}" role="button">{{ __('Password') }}</a>
                        <a class="btn btn-danger btn-sm mb-1" href="/profile/delete/{{$user->id}}" role="button">{{ __('Delete') }}</a>
                      </td>

                    </tr>
                    @endforeach
                </tbody>
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

