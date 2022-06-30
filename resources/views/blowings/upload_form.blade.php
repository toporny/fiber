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

    <form method="post" enctype="multipart/form-data" action="{{ route('blowings.uploadSubmit1') }}">
      @csrf

      <div class="container g-0">
        <div class="row mt-1">
          <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
            select
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
              <select class="form-select" aria-label="Default select example" name="company_select" id="company_select_id" onchange="myFunction(this.value)">
                <option value="-1">-- wybierz lub wpisz nowy --</option>
                @foreach ($clients_list as $client_item)
                  <option value="{{$client_item->client_name}}#{{$client_item->client_address}}#{{$client_item->client_nip}}">{{$client_item->client_name}}</option>
                @endforeach
              </select>
          </div>
        </div>

        <div class="row mt-4">
          <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
            client_name
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
              <input type="text" maxlength="50" class="form-control @error('client_name') is-invalid @enderror" name="client_name" id="client_name_id" autocomplete="client_name" value="{{$client->client_name}}">
              @error('client_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('client_name') }}</strong>
                </span>
              @enderror
          </div>
        </div>

        <div class="row mt-1">
          <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
            client_address
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
              <input type="text" maxlength="50" class="form-control @error('client_address') is-invalid @enderror" name="client_address" id="client_address_id" autocomplete="client_address" value="{{$client->client_address}}">
                  @error('client_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('client_address') }}</strong>
                    </span>
                  @enderror
          </div>
        </div>

        <div class="row mt-1">
          <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
            client_nip
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
              <input type="text" maxlength="50" class="form-control @error('client_nip') is-invalid @enderror" name="client_nip" id="client_nip_id" autocomplete="client_nip" value="{{$client->client_nip}}">
                  @error('client_nip')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('client_nip') }}</strong>
                    </span>
                  @enderror
          </div>
        </div>

        <div class="row mt-1">
          <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
            add_to_database
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <input class="mt-3 form-check-input" type="checkbox" name="add_record_to_database">
          </div>
        </div>


        <div class="form-group mb-4 mt-4">

            
        </div>


        <div class="row mt-1">
          <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
            Select 3 blowing files
          </div>
          <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <label for="Product Name">(<span class="text-primary">gps.txt</span>, <span class="text-success">parameters.txt</span>, <span class="text-danger">table.bin</span>)</label>
            <input type="file" class="mt-2 form-control" name="files[]" multiple />
            @error('files[]')
              <span style="color: red"  role="alert">
                  <strong>{{ $errors->first('files[]') }}</strong>
              </span>
            @enderror
          </div>
        </div>




        <div class="row mt-1">
          <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
            
          </div>
          <div class="mt-3 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
                <input class="btn btn-lg btn-primary" type="submit" value="Uplaod & Submit">
                <a class="btn btn-lg m-2 btn-secondary" href="/clients/list" role="button">{{ __('Back') }}</a>
          </div>
        </div>






        <script type="text/javascript">

            function myFunction(val) {
                var a = val.split("#");
                if (a.length == 3) {
                    console.log(a);
                    document.getElementById("client_name_id").value = a[0];
                    document.getElementById("client_address_id").value = a[1];
                    document.getElementById("client_nip_id").value = a[2];

                    // let element = document.getElementById('company_select_id');
                    // element.value = "-1";
                }
            }

        </script>

      </div>
    </form>


    @endauth

  </div>
@endsection

