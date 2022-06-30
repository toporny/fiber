@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth

        <h2 class="mb-4">Show blowing sources</h2>

<div class="container g-0">

  <div class="row mt-1">
    <div class="text-black-50 text-md-end col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
        <table class="table table-hover table-bordered table-sm ">
            <thead>
              <th class="text-center">date time</th>
              <th class="text-center">speed</th>
              <th class="text-center">force</th>
              <th class="text-center">pressure</th>
              <th class="text-center">length</th>
            </thead>
            <tbody>
                @foreach($source_data1 as $source)
                <tr>
                  <td class="text-center">{{$source->datetime}}</td>
                  <td class="text-center">{{$source->speed}}</td>
                  <td class="text-center">{{ sprintf("%.2f", $source->force) }}</td>
                  <td class="text-center">{{$source->pressure}}</td>
                  <td class="text-center">{{ sprintf("%.2f", $source->length) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-black-50 text-md-end col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
        <table class="table table-hover table-bordered table-sm">
            <thead>
              <th class="text-center">date time</th>
              <th class="text-center">speed</th>
              <th class="text-center">force</th>
              <th class="text-center">pressure</th>
              <th class="text-center">length</th>
            </thead>
            <tbody>
                @foreach($source_data2 as $source)
                <tr>
                  <td class="text-center">{{$source->datetime}}</td>
                  <td class="text-center">{{$source->speed}}</td>
                  <td class="text-center">{{ sprintf("%.2f", $source->force) }}</td>
                  <td class="text-center">{{$source->pressure}}</td>
                  <td class="text-center">{{ sprintf("%.2f", $source->length) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

  </div>


</div>


  <div class="container g-0 mt-4">

  <a class="m-2 btn btn-primary btn btn-lg" href="/blowings/list" role="button">{{ __('Back') }}</a>
  </div>

        @endauth

        
    </div>
@endsection

