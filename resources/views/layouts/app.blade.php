<!DOCTYPE html>
<html lang="en">
  
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/main/images/Viti.png')}}">
    <link rel="stylesheet" href="{{asset('assets/viti_new/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/viti_new/css/style.css')}}">
    <!-- Responsive stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/viti_new/css/responsive.css')}}">
    <script>
        window.__INITIAL_STATE__ = "{{url('/')}}";
    </script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/viti2/css/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/viti2/css/responsive.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/viti2/css/chosen.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/viti2/css/colors/colors.css')}}" />
    <!-- fontawesome css -->
    <script src="https://kit.fontawesome.com/9bfb9a77dd.js" crossorigin="anonymous"></script>
    <link href="{{asset('assets/toastr/toastr.min.css')}}" rel="stylesheet"/>

    @if(Auth::guard('employer')->check() or Auth::guard('manager')->check() or Auth::check())
    
    
    <link rel="stylesheet" href="{{asset('assets/student_new/vendor/nucleo/css/nucleo.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/student_new/css/argon.css?v=1.1.0')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/user/css/mnav.css')}}" type="text/css">
    @endif
    @stack('styles')
    @yield('heads')
    <style>
      body{
        background: #fff;
      }
      .main-c{
        margin-top: 6rem;
      }
    </style>
  </head>
  <body>
    @include('includes.header')
    <div class="main-c">
    @yield('content')
    
    </div>
    @include('includes.footer')

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- Wrapper End -->
<script type="text/javascript" src="{{asset('assets/viti_new/js/jquery-3.3.1.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/jquery-migrate-3.0.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/jquery.mmenu.all.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/ace-responsive-menu.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/bootstrap-select.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/snackbar.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/simplebar.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/tagsinput.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/parallax.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/scrollto.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/jquery-scrolltofixed-min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/jquery.counterup.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/wow.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/progressbar.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/slider.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/timepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/viti_new/js/wow.min.js')}}"></script>
<!-- Custom script for all pages --> 
<script type="text/javascript" src="{{asset('assets/viti_new/js/script.js')}}"></script>

<script src="{{asset('assets/viti2/js/modernizr.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/viti2/js/script.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/user/js/mnav.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/toastr/toastr.min.js')}}"></script>

  <script>
  @if(Session()->has('success'))

  toastr.success("{{Session('success')}}")
  @endif

  @if(Session()->has('warning'))

  toastr.warning("{{Session('warning')}}")
  @endif

  @if(count($errors)>0)
      @foreach($errors->all() as $error)
          toastr.error("{{$error}}")
      @endforeach
  @endif
    </script>
    @stack('scripts')
  @yield('scripts')
</body>
</html>