@extends('auth.partials.app')

@section('content')
<!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box login-box">
                <!-- Start row -->
                <div class="row no-gutters align-items-center justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-6 col-lg-5">
                        <!-- Start Auth Box -->
                        <div class="auth-box-right">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}
                                        <div class="form-head">
                                            <a href="#" class="logo"><img src="{{asset('assets/images/logo.png')}}" class="img-fluid" alt="logo">
                                                <h3 class="text-primary my-4">Repositorio</h3>
                                            </a>
                                        </div>                                        
                                        <!--h4 class="text-primary my-4">Log in !</h4-->
                                        <div class="form-group">
                                            <!--input type="text" class="form-control" id="username" placeholder="Enter Username here" required-->
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  autofocus placeholder="Ingresar Email">

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <!--input type="password" class="form-control" id="password" placeholder="Enter Password here" required-->
                                            <input id="password" type="password" class="form-control" name="password"  placeholder="Ingresar Password">
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                                                  
                                        <button type="submit" class="btn btn-success btn-lg btn-block font-18" style="background-color:#016352">Iniciar sesión</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Auth Box -->
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End Container -->
    </div>
<!-- End Containerbar -->
@endsection
