@extends('layouts.app')

@section('content')
	<div class="card">
    <div class="card-body">
        <h1>{{__('Carga de informacion por CSV')}}</h1>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="loadpage">
                  <!-- Message -->
                  @if(Session::has('message'))
                    <p class="alert alert-success">{{ Session::get('message') }}</p>
                  @endif
                </div>
                <!-- Form -->
                <form method='post' action={{ url('uploadFile') }} enctype='multipart/form-data' >
                  {{ csrf_field() }}
                  <input type='file' name='file' required><br><br>
                  <input type="submit" name="submit" value="{{__('Importar')}}" class="btn bg-primary mr-2 text-light">
                </form><br><br>
                <!-- Errors -->
                <div class="errorsLoad">
                  @if(!empty($errors))
                    @foreach($errors as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                    @endforeach
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
@endsection
@section('script-custom')

@endsection
