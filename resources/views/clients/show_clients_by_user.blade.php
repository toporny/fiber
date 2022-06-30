@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-3 rounded">
        <h2>Show clients</h2>

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

<form method="POST" action="{{ route('clients.deleteManyClientsConfirm') }}">
    @csrf
            <table class="table table-hover">
                <thead>
                  <th class="align-middle"></th>
                  <th class="align-middle">{{ __('client_name') }}</th>
                  <th class="align-middle">{{ __('address') }}</th>
                  <th class="align-middle"><span class="d-none d-md-block">{{ __('nip') }}</span></th>
                  <th class="align-middle text-center"><span class="d-none d-md-block">{{ __('created_at') }}</span></th>
                  <th class="align-middle">{{ __('action') }} 

                  </th>
                </thead>

                <tbody>
                    <div class="form-check">
                    @foreach($clients as $client)
                    <tr>
                        <td class="align-middle"><input data-myattribute="{{ $client->id }}" class="form-check-input check_box_clients" type="checkbox" name="client_ids[{{ $client->id }}]"></td>
                        <td class="align-middle">{{ $client->client_name }}</td>
                        <td class="align-middle">{{ $client->client_address }}</td>
                        <td class="align-middle"><span class="d-none d-md-block">{{ $client->client_nip }}</span></td>
                        <td class="align-middle text-center">
                            <span class="d-none d-md-block" style="white-space: nowrap;">
                                {{ substr($client->created_at, 0, 10)}} {{ substr($client->created_at, 11, 5)}}
                            </span>
                        </td>
                        <td class="align-middle">
                            <a class="btn btn-warning btn-md mb-1" href="/clients/edit/{{$client->id}}" role="button">{{ __('Edit') }}</a>
                        </td>
                    </tr>
                    @endforeach
                    </div>
                </tbody>
            </table>

            <style type="text/css">
            div>p.text-muted { display:none; }
            </style>

            <div class="d-flex justify-content-center mt-4">
                {{ $clients->links() }}
            </div>

            <a class="btn btn-success btn btn-lg" href="/clients/add" role="button">{{ __('Dodaj nowy') }}</a>
            <a class="m-3 btn btn-secondary btn btn-lg"  href="/profile" role="button">{{ __('Back to profile') }}</a>
            <input class="btn btn-danger btn btn-lg" id="delete_button" disabled type="submit" value="{{ __('Delete selected') }}">
            
            <script type="text/javascript">
                var myFunction = function( event ) {
                    var attribute = event.target.getAttribute("data-myattribute");
                    var suma = 0;
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].checked == true) {
                            suma++;
                        }
                    }
                    var button = document.getElementById('delete_button');
                    (suma == 0) ? button.setAttribute('disabled', '') : button.removeAttribute('disabled');
                };

                const checkboxes = document.querySelectorAll( 'input[type=checkbox].check_box_clients' );
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].addEventListener('change', myFunction, false);
                }
            </script>


</form>
        @endauth

        @guest
        <h1>Homepage</h1>
        <p class="lead">
            {{ __('Your viewing the home page. Please login to view the restricted data.')}}
        </p>
        @endguest

    </div>
@endsection

