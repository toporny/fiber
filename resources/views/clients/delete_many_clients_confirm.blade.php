@extends('layouts.app-master')

@section('content')
  <div class="bg-light p-5 rounded">
    @auth

    <h2 class="text-danger">Are you sure to delete all this records?</h2>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">client_name</th>
            <th scope="col">client_address</th>
            <th scope="col">client_nip</th>
            <th scope="col">created_at</th>
          </tr>
        </thead>
        <tbody>

          @foreach($clients as $client)
          <tr>
            <td>{{$client->client_name}}</td>
            <td>{{$client->client_address}}</td>
            <td>{{$client->client_nip}}</td>
            <td>{{$client->created_at}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

    <form method="POST" action="/client/delete">
      @csrf
      
      @foreach($clients as $client)
        <input type="hidden" name="client_ids[{{$client->id}}]" value="1">
      @endforeach

      <input type="submit" class="btn btn-danger btn btn-lg" value="{{ __('Delete') }}">
      <a class="m-3 btn btn-secondary btn btn-lg" href="/clients/list" role="button">{{ __('Back') }}</a>
    </form>

    @endauth

  </div>
@endsection

