<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Orbiter is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, responsive, bootstrap 4, ui kits, ecommerce, web app, crm, cms, html, sass support, scss">
    <meta name="author" content="Themesbox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
     <title>{{env('APP_NAME')}}</title>
    <!-- Fevicon -->
    <!--link rel="shortcut icon" href="assets/images/favicon.ico"-->
    <!-- Start css -->
    <!-- Switchery css -->
    <link href="{{ asset('assets/plugins/switchery/switchery.min.css')}}" rel="stylesheet">
    <!-- Apex css -->
    <link href="{{ asset('assets/plugins/apexcharts/apexcharts.css')}}" rel="stylesheet">
    <!-- Slick css -->
    <link href="{{ asset('assets/plugins/slick/slick.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/slick/slick-theme.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/flag-icon.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('hotspot') }}/jquery.hotspot.css">
    
    <!-- End css -->
</head>
<body class="vertical-layout">
    <!-- Start Containerbar -->
    <div id="containerbar">
        @include("layouts/partials/sidebar")
        <!-- Start Rightbar -->
        <div class="rightbar">
            @include('layouts/partials/topbar')