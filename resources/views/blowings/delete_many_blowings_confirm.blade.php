@extends('layouts.app-master')

@section('content')
  <div class="bg-light p-5 rounded">
    @auth

    <h2 class="text-danger">Are you sure to delete all this records?</h2>
    <form method="POST" action="/blowing/delete">
      @csrf
      <table class="table">
        <thead>
          <tr>
            <th scope="col">client_name</th>
            <th scope="col">client_address</th>
            <th scope="col">route_name</th>
            <th scope="col">date_time</th>
          </tr>
        </thead>
        <tbody>

          @foreach($blowings as $blowing)
          <tr>
            <td>{{$blowing->client_name}}</td>
            <td>{{$blowing->client_address}}</td>
            <td>{{$blowing->route_name}}</td>
            <td>{{substr($blowing->date_time_from_file,0,16)}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      @foreach($blowings as $blowing)
        <input type="hidden" name="blowing_ids[{{$blowing->id}}]" value="1">
      @endforeach
      <input type="submit" class="btn btn-danger btn btn-lg" value="{{ __('Delete') }}">
      <a class="m-3 btn btn-secondary btn btn-lg" href="/blowings/list" role="button">{{ __('Back') }}</a>
    </form>

    @endauth

  </div>
@endsection

