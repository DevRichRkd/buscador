<style>
    .vertical-menu > li > a {
        color: #fcb263;
    }
    .vertical-menu a {
        color: #ffffff;
    }
    .vertical-menu > li.active > a {
        color: #e7e8e8;
    }
    
    .vertical-menu > li:hover > a {
        color: #e7e8e8;
    }
</style>
<!-- Start Leftbar -->
<div class="leftbar">
    <!-- Start Sidebar -->
    <div class="sidebar" style="background-color: #000000;">
        <!-- Start Logobar -->
        <div class="logobar" style="background-color: #b7b7b7">
            <a href="{{ url('/') }}" class="logo logo-large">
                <img src="{{asset('assets/images/logo.png')}}" class="img-fluid" alt="logo"-->
                <h1 class="text-white font-weight-bold">Buscadores</h1>
            </a>
            <a href="index.html" class="logo logo-small">
                <img src="{{asset('assets/images/logo.png')}}" class="img-fluid" alt="logo"-->
                <h1 class="text-white font-weight-bold">R</h1>
            </a>
        </div>
        <!-- End Logobar -->
        <!-- Start Navigationbar -->
        <div class="navigationbar">
            <ul class="vertical-menu">

                <!--li>
                    <a href="javaScript:void();">
                        <img src="{{asset('assets/images/svg-icon/maps.svg')}}" class="img-fluid" alt="maps"><span>Maps</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="map-google.html">Google</a></li>
                        <li><a href="map-vector.html">Vector</a></li>
                    </ul>
                </li>
                <li>
                    <a href="widgets.html">
                        <img src="{{asset('assets/images/svg-icon/widgets.svg')}}" class="img-fluid" alt="widgets"><span>Widgets</span><span class="badge badge-success pull-right">New</span>
                    </a>
                </li-->     

                @include('layouts/partials/menu_manager')
                @if (! Auth::guest())
                    @if(Auth::user()->estatus == 1)
                      {{menus()}}
                    @endif
                @endif    
                                                   
            </ul>
        </div>
        <!-- End Navigationbar -->
    </div>
    <!-- End Sidebar -->
</div>
<!-- End Leftbar -->