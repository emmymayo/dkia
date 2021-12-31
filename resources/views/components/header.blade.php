<!DOCTYPE html>
<html lang="en"  style="height:auto">


<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        
        <title>{{$title}}</title>
         <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="/css/animate.min.css">
        <link rel="stylesheet" href="/css/custom.css">
        <style>[v-cloak]{display:none}</style>

        {{$slot}}

        @livewireStyles

        
</head>

<body class="hold-transition sidebar-mini sidebar-collapse animate__animated animate__fadeIn animate__slow " 
        style="height:auto;">
    

    
<div class="wrapper">

