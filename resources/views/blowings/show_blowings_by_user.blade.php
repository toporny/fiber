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

<h2>Show blowing</h2>

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
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      client_name
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
        {{$blowing->client_name}}
    </div>

    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      client_nip
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        {{$blowing->client_nip}}
    </div>
  </div>


  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      client_address
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        {{$blowing->client_address}}
    </div>
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      language
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{$blowing->language}}
    </div>
</div> 


<div class="container g-0">
  <h5 class="mt-4 mb-0">Route</h5>
  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      route_name
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        {{$blowing->route_name}}
    </div>

    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      operator
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
        {{$blowing->operator}}
    </div>
  </div>


  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      route_start
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{$blowing->route_start}}
    </div>

    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      route_end
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
      {{$blowing->route_end}}
    </div>
  </div>


  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      place_location
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{$blowing->place_location}}
    </div>
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      gps_lat_long
    </div>
    
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{$blowing->route_gps_cords_x}}, {{$blowing->route_gps_cords_y}} 
    </div>
    
  </div>
</div>


<div class="container g-0">
  <h5 class="mt-4 mb-0">Pipe</h5>
  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      pipe_manufacturer
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
      {{$blowing->pipe_manufacturer}}
    </div>
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      pipe_type
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{$blowing->pipe_type}}
    </div>
  </div>


  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      pipe_symbol_color
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
      {{$blowing->pipe_symbol_color}}
    </div>
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      outer_diameter
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{$blowing->pipe_outer_diameter}}
    </div>
  </div>


  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      pipe_thickness
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
      {{$blowing->pipe_thickness}}
    </div>
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      pipe_notes
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{$blowing->pipe_notes}}
    </div>
  </div>
</div>


<div class="container g-0">
  <h5 class="mt-4 mb-0">Cable</h5>

  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      cable_manufacturer
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
      {{$blowing->cable_manufacturer}}
    </div>
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      how_many_fibers
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
      {{$blowing->cable_how_many_fibers}}
    </div>
  </div>



  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      symbol_color / diameter
    </div>
    <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
        {{$blowing->cable_symbol_color}}
    </div>
    <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
        {{$blowing->cable_diameter}}
    </div>
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      cable_crash_test
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        {{$blowing->cable_crash_test}}
    </div>
  </div>



  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      marker start / stop
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        {{$blowing->cable_marker_start}} / {{$blowing->cable_marker_end}}
    </div>
  </div>





<div class="container g-0">
  <h5 class="mt-4 mb-0">Blower</h5>

  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      blower_lubricant
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
        {{$blowing->blower_lubricant}}
    </div>
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      blower_compressor
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        {{$blowing->blower_compressor}}
    </div>
  </div>


  <div class="row">
    <div class="text-md-end pt-1 col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      pressure
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xxl-4 col-xl-4">
        {{$blowing->blower_compressor_pressure}}
    </div>
    <div class="pt-1 text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      efficiency
    </div>
    <div class="col-12 col-sm-12 col-md-8 col-lg-4 col-xl-4 col-xxl-4">
        {{$blowing->blower_compressor_efficiency}}
    </div>

  </div>
</div>



  <div class="row">
    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      settings
    </div>
    <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
      {{($blowing->blower_separator == 1) ? "[x]" : "[ ]"}}
        separator
    </div>
    <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-xxl-2 col-xl-2">
      {{($blowing->blower_radiator == 1) ? "[x]" : "[ ]"}}
        radiator
    </div>

    <div class="text-md-end col-12 col-sm-12 col-md-4 col-lg-2 col-xl-2 col-xxl-2">
      Temperature °C
    </div>
    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
        {{ $errors->first('temperature') }}
    </div>

  </div>
</div>

<div class="container g-0 mt-4">
    <input type="hidden" name="blowing_id" value="{{$blowing->id}}"></button>
    <a class="btn btn-lg m-2 btn-secondary" href="{{ route('blowings.blowingsList') }}" role="button">{{ __('Back') }}</a>
</div>


        @endauth

        
    </div>
@endsection

