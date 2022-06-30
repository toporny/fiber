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

<h2>Edit blowing</h2>


<form method="POST" enctype="multipart/form-data" action="{{ route('blowings.uploadSubmit2') }}">

    @csrf

<div class="container g-0">

  <h5 class="mt-4 mb-0">Source File</h5>
  <div class="row mt-2">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      Client name
    </div>

    <div class="overflow-hidden col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{$blowing->client_name_from_file}}
    </div>

    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      Blowing date
    </div>
    
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{ substr($blowing->date_time_from_file, 0, 10)}}
    </div>
  </div>


  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      Instalation Time
    </div>

    <div class="overflow-hidden col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{substr($blowing->installation_time_start,-8)}} - {{substr($blowing->installation_time_end,-8)}} 
      ({{$blowing->installation_time_in_minutes}} minutes)
    </div>

    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      Blowing finish
    </div>
    
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{ substr($blowing->date_time_from_file, 11, 8)}}
    </div>
  </div>



  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      Samples
    </div>

    <div class="overflow-hidden col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{$blowing->numbers_of_samples_from_file}}
    </div>
    
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      GPS
    </div>
    
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
    <a target="_new" class="link-dark" href="http://google.com/maps/place/{{$blowing->route_gps_cords_x}}{{$blowing->route_gps_cords_y}}">{{$blowing->route_gps_cords_x}},{{$blowing->route_gps_cords_y}}</a>
    </div>

  </div>





  <h5 class="mt-4 mb-0">Client</h5>

  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      client_name
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
        <input type="text" maxlength="50" class="form-control @error('client_name') is-invalid @enderror" name="client_name" autocomplete="client_name" value="{{$blowing->client_name}}">
        @error('client_name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('client_name') }}</strong>
          </span>
        @enderror
    </div>

    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      client_nip
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        <input type="text" maxlength="50" class="form-control @error('client_nip') is-invalid @enderror" name="client_nip" autocomplete="client_nip" value="{{$blowing->client_nip}}">
            @error('client_nip')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('client_nip') }}</strong>
              </span>
            @enderror
    </div>
  </div>

  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      client_address
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        <input type="text" maxlength="50" class="form-control @error('client_address') is-invalid @enderror" name="client_address" autocomplete="client_address" value="{{$blowing->client_address}}">
        @error('client_address')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('client_address') }}</strong>
          </span>
        @enderror
    </div>
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      language
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      <select class="form-select" aria-label="Default select example" name="language">
      @foreach (Config::get('languages') as $lang => $language_value)
        @if (strtolower($blowing->language) == $lang)
          <option selected="selected" value="{{$lang}}">{{$language_value}}</option>
        @else
          <option value="{{$lang}}">{{$language_value}}</option>
        @endif
      @endforeach
      </select>
    </div>
</div> 

<div class="container g-0">
  <h5 class="mt-4 mb-0">Route</h5>
  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      route_name
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        <input type="text" maxlength="50" class="form-control @error('route_name') is-invalid @enderror" name="route_name" autocomplete="route_name" value="{{$blowing->route_name}}">
            @error('route_name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('route_name') }}</strong>
              </span>
            @enderror
    </div>

    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      operator
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
            <input type="text" maxlength="50" class="form-control @error('operator') is-invalid @enderror" name="operator" autocomplete="operator" value="{{$blowing->operator}}">
            @error('operator')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('operator') }}</strong>
              </span>
            @enderror
    </div>
  </div>

  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      route_start
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <input type="text" maxlength="50" class="form-control @error('route_start') is-invalid @enderror" name="route_start" autocomplete="route_start" value="{{$blowing->route_start}}">
            @error('route_start')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('route_start') }}</strong>
              </span>
            @enderror
    </div>

    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      route_end
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
            <input type="text" maxlength="50" class="form-control @error('route_end') is-invalid @enderror" name="route_end" autocomplete="route_end" value="{{$blowing->route_end}}">
            @error('route_end')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('route_end') }}</strong>
              </span>
            @enderror
    </div>
  </div>

  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      place_location
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <input type="text" maxlength="50" class="form-control @error('place_location') is-invalid @enderror" name="place_location" autocomplete="place_location" value="{{$blowing->place_location}}">
            @error('place_location')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('place_location') }}</strong>
              </span>
            @enderror
    </div>
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      gps_lat_long
    </div>
    
    <div class="mb-1 col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
      <input type="text" maxlength="50" class="form-control @error('route_gps_cords_x') is-invalid @enderror" name="route_gps_cords_x" autocomplete="route_gps_cords_x" value="{{$blowing->route_gps_cords_x}}">
      @error('route_gps_cords_x')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('route_gps_cords_x') }}</strong>
        </span>
      @enderror
    </div>
    
    <div class="mb-1 col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
      <input type="text" maxlength="50" class="form-control @error('route_gps_cords_y') is-invalid @enderror" name="route_gps_cords_y" autocomplete="route_gps_cords_y" value="{{$blowing->route_gps_cords_y}}">
      @error('route_gps_cords_y')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('route_gps_cords_y') }}</strong>
        </span>
      @enderror
    </div>

  </div>
</div>

<div class="container g-0">
  <h5 class="mt-4 mb-0">Pipe</h5>
  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      pipe_manufacturer
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
            <input type="text" maxlength="50" class="form-control @error('pipe_manufacturer') is-invalid @enderror" name="pipe_manufacturer" autocomplete="pipe_manufacturer" value="{{$blowing->pipe_manufacturer}}">
            @error('pipe_manufacturer')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('pipe_manufacturer') }}</strong>
              </span>
            @enderror
    </div>
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      pipe_type
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <input type="text" maxlength="50" class="form-control @error('pipe_type') is-invalid @enderror" name="pipe_type" autocomplete="pipe_type" value="{{$blowing->pipe_type}}">
            @error('pipe_type')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('pipe_type') }}</strong>
              </span>
            @enderror
    </div>
  </div>

  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      pipe_symbol_color
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
            <input type="text" maxlength="50" class="form-control @error('pipe_symbol_color') is-invalid @enderror" name="pipe_symbol_color" autocomplete="pipe_symbol_color" value="{{$blowing->pipe_symbol_color}}">
            @error('pipe_symbol_color')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('pipe_symbol_color') }}</strong>
              </span>
            @enderror
    </div>
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      outer_diameter
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <input type="text" maxlength="50" class="form-control @error('pipe_outer_diameter') is-invalid @enderror" name="pipe_outer_diameter" autocomplete="pipe_outer_diameter" value="{{$blowing->pipe_outer_diameter}}">
            @error('pipe_outer_diameter')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('pipe_outer_diameter') }}</strong>
              </span>
            @enderror
    </div>
  </div>

  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      pipe_thickness
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
            <input type="text" maxlength="50" class="form-control @error('pipe_thickness') is-invalid @enderror" name="pipe_thickness" autocomplete="pipe_thickness" value="{{$blowing->pipe_thickness}}">
            @error('pipe_thickness')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('pipe_thickness') }}</strong>
              </span>
            @enderror
    </div>
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      pipe_notes
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <input type="text" maxlength="50" class="form-control @error('pipe_notes') is-invalid @enderror" name="pipe_notes" autocomplete="pipe_notes" value="{{$blowing->pipe_notes}}">
            @error('pipe_notes')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('pipe_notes') }}</strong>
              </span>
            @enderror
    </div>
  </div>
</div>

<div class="container g-0">
  <h5 class="mt-4 mb-0">Cable</h5>

  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      cable_manufacturer
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
            <input type="text" maxlength="50" class="form-control @error('cable_manufacturer') is-invalid @enderror" name="cable_manufacturer" autocomplete="cable_manufacturer" value="{{$blowing->cable_manufacturer}}">
            @error('cable_manufacturer')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('cable_manufacturer') }}</strong>
              </span>
            @enderror
    </div>
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      how_many_fibers
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <input type="text" maxlength="50" class="form-control @error('cable_how_many_fibers') is-invalid @enderror" name="cable_how_many_fibers" autocomplete="cable_how_many_fibers" value="{{$blowing->cable_how_many_fibers}}">
            @error('cable_how_many_fibers')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('cable_how_many_fibers') }}</strong>
              </span>
            @enderror
    </div>
  </div>

  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      symbol_color / diameter
    </div>
    <div class="mb-1 col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
        <input type="text" maxlength="50" class="form-control @error('cable_symbol_color') is-invalid @enderror" name="cable_symbol_color" autocomplete="cable_symbol_color" value="{{$blowing->cable_symbol_color}}">
        @error('cable_symbol_color')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('cable_symbol_color') }}</strong>
          </span>
        @enderror
    </div>
    <div class="mb-1 col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
        <input type="text" maxlength="50" class="form-control @error('cable_diameter') is-invalid @enderror" name="cable_diameter" autocomplete="cable_diameter" value="{{$blowing->cable_diameter}}">
        @error('cable_diameter')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('cable_diameter') }}</strong>
          </span>
        @enderror
    </div>
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      cable_crash_test
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <input type="text" maxlength="50" class="form-control @error('cable_crash_test') is-invalid @enderror" name="cable_crash_test" autocomplete="cable_crash_test" value="{{$blowing->cable_crash_test}}">
            @error('cable_crash_test')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('cable_crash_test') }}</strong>
              </span>
            @enderror
    </div>
  </div>

  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      marker start / stop
    </div>
    <div class="mb-1 col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
        <input type="text" maxlength="50" class="form-control @error('cable_marker_start') is-invalid @enderror" name="cable_marker_start" autocomplete="cable_marker_start" value="{{$blowing->cable_marker_start}}">
        @error('cable_marker_start')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('cable_marker_start') }}</strong>
          </span>
        @enderror
    </div>
    <div class="mb-1 col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
        <input type="text" maxlength="50" class="form-control @error('cable_marker_end') is-invalid @enderror" name="cable_marker_end" autocomplete="cable_marker_end" value="{{$blowing->cable_marker_end}}">
        @error('cable_marker_end')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('cable_marker_end') }}</strong>
          </span>
        @enderror
    </div>
  </div>



<div class="container g-0">
  <h5 class="mt-4 mb-0">Fiber Blowing Machine</h5>

  <div class="row">

    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      blower_serial_number
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
            <input type="text" maxlength="50" class="form-control @error('blower_serial_number') is-invalid @enderror" name="blower_serial_number" autocomplete="blower_serial_number" value="{{$blowing->blower_serial_number}}">
            @error('blower_serial_number')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('blower_serial_number') }}</strong>
              </span>
            @enderror
    </div>

    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      blower_lubricant
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
            <input type="text" maxlength="50" class="form-control @error('blower_lubricant') is-invalid @enderror" name="blower_lubricant" autocomplete="blower_lubricant" value="{{$blowing->blower_lubricant}}">
            @error('blower_lubricant')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('blower_lubricant') }}</strong>
              </span>
            @enderror
    </div>
  </div>


  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      blower_compressor
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
            <input type="text" maxlength="50" class="form-control @error('blower_compressor') is-invalid @enderror" name="blower_compressor" autocomplete="blower_compressor" value="{{$blowing->blower_compressor}}">
            @error('blower_compressor')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('blower_compressor') }}</strong>
              </span>
            @enderror
    </div>

    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      blower_pressure
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      <input type="text" maxlength="50" class="form-control @error('blower_compressor_pressure') is-invalid @enderror" name="blower_compressor_pressure" autocomplete="blower_compressor_pressure" value="{{$blowing->blower_compressor_pressure}}">
      @error('blower_compressor_pressure')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('blower_compressor_pressure') }}</strong>
      </span>
      @enderror
    </div>
  </div>


  <div class="row">
    <div class="text-md-end pt-1 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      blower_efficiency
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
            <input type="text" maxlength="50" class="form-control @error('blower_compressor_efficiency') is-invalid @enderror" name="blower_compressor_efficiency" autocomplete="blower_compressor_efficiency" value="{{$blowing->blower_compressor_efficiency}}">
            @error('blower_compressor_efficiency')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('blower_compressor_efficiency') }}</strong>
              </span>
            @enderror
    </div>
    <div class="pt-1 text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      Temperature °C
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        <input type="text" maxlength="50" class="form-control @error('temperature') is-invalid @enderror" name="temperature" autocomplete="temperature" value="{{$blowing->temperature}}">
        @error('temperature')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('temperature') }}</strong>
          </span>
        @enderror
    </div>

  </div>

  <div class="row">
    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      settings
    </div>
    <div class="mb-1 col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
      <input class="mt-2 form-check-input" name="separator" type="checkbox" {{($blowing->blower_separator == 1) ? "checked" : ""}}>
      <label class="mt-1 form-check-label">
        separator
      </label>
    </div>
    <div class="mb-1 col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
      <input class="mt-2 form-check-input" name="radiator" type="checkbox" {{($blowing->blower_radiator == 1) ? "checked" : ""}}>
      <label class="mt-1 form-check-label">
        radiator
      </label>
    </div>

    <div class="text-md-end pt-2 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      
    </div>
    <div class="mb-1 col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
    </div>
  </div>



</div>

    <input type="hidden" name="blowing_id" value="{{$blowing->id}}"></button>
    <button class="btn btn-lg btn-primary" type="submit">Submit</button>
    <a class="btn btn-lg m-2 btn-secondary" href="/blowings/list" role="button">{{ __('Back') }}</a>
</form>


        @endauth

        
    </div>
@endsection

