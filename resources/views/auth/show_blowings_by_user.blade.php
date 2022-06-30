@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-3 rounded">
        <h2>Show blowings</h2>
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

            <form method="POST" action="{{ route('blowings.deleteManyBlowingsConfirm') }}">
                @csrf
                <table class="table table-hover">
                    <thead>
                      <th class="align-middle">
                        @if(count($blowings) > 0)
                          <input class="form-check-input check_box_blowings" type="checkbox" id="select_deselect_all">
                        @endif
                      </th>
                      <th class="align-middle text-center">{{ __('date') }}</th>
                      <th class="align-middle">{{ __('client_name') }}</th>
                      <th class="align-middle">{{ __('address') }}</th>
                      <th class="align-middle">{{ __('action') }}</th>
                    </thead>


                    <tbody>
                        <div class="form-check">
                        @foreach($blowings as $blowing)
                        <tr @if ($blowing->draft == 1)class="table-secondary" class="table-secondary" @endif>
                            <td class="align-middle"><input data-myattribute="{{ $blowing->id }}" class="form-check-input check_box_blowings" type="checkbox" name="blowing_ids[{{ $blowing->id }}]"></td>
                            <td class="align-middle text-center"><span style="white-space: nowrap;">{{ substr($blowing->date_time_from_file, 0, 10)}}</span><br>{{ substr($blowing->date_time_from_file, 11, 5)}}</span></td>
                            <td class="align-middle">{{ $blowing->client_name }}</td>
                            <td class="align-middle">{{ $blowing->client_address }}</td>
                            <td class="align-middle">
                                <a role="button" href="{{ route('blowings.showBlowing', $blowing->id) }}" class="btn btn-success btn-sm mb-1">{{ __('Details') }}</a>
                                <a role="button" href="{{ route('blowings.editBlowing', $blowing->id) }}" class="btn btn-primary btn-sm mb-1">{{ __('Edit') }}</a>
                                <a role="button" href="{{ route('blowings.showBlowingSource', $blowing->id) }}" class="btn btn-warning btn-sm mb-1">{{ __('Source') }}</a>
                                <a role="button" href="{{ route('blowings.makePdfBlowing', $blowing->id) }}" class="btn btn-secondary btn-sm mb-1">{{ __('PDF') }}</a>
                                <a role="button" href="/pdf/show_chart/{{$blowing->id}}" class="btn btn-info btn-sm mb-1">{{ __('Chart') }}</a>
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
                {{ $blowings->links() }}
                </div>

                <a class="btn btn-success btn btn-lg" href="/blowings/add" role="button">{{ __('Dodaj nowy') }}</a>
                <a class="m-3 btn btn-secondary btn btn-lg"  href="/profile/" role="button">{{ __('Back to profile') }}</a>
                <input class="btn btn-danger btn btn-lg" id="delete_button" disabled type="submit" value="{{ __('Delete selected') }}">
            </form>


            <script type="text/javascript">

                @if(count($blowings) > 0)
                    var button_select_all = document.getElementById('select_deselect_all');
                    button_select_all.addEventListener('change', function() {
                        for (var i = 0; i < checkboxes.length; i++) {
                            checkboxes[i].checked = this.checked;
                        }
                    });
                @endif

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

                const checkboxes = document.querySelectorAll( 'input[type=checkbox].check_box_blowings' );
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].addEventListener('change', myFunction, false);
                }
            </script>
        @endauth

        @guest
        <h1>Homepage</h1>
        <p class="lead">
            {{ __('Your viewing the home page. Please login to view the restricted data.')}}
        </p>
        @endguest

    </div>
@endsection

