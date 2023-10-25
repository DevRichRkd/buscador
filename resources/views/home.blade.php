@extends('layouts/app')

@section('content')
     <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-xl-12">
            <div class="card m-b-30">
                <div class="card-header">                                
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h5 class="card-title mb-0">Bienvenido</h5>
                        </div>
                        <div class="col-3">
                            <div class="dropdown">
                                <button class="btn btn-link p-0 font-18 float-right" type="button" id="widgetRevenue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="widgetRevenue">
                                    <a class="dropdown-item font-13" href="#">Refresh</a>
                                    <a class="dropdown-item font-13" href="#">Export</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body py-0">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            
                        </div>
                        <div class="col-lg-9">
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col --> 
    </div>
    <!-- End row -->    
@endsection
