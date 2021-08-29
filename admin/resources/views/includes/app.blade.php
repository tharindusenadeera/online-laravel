<html>
    <head>
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title') | Restaurant Manager</title>
        <!-- Tell the browser to be responsive to screen width -->
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 @include('includes.basicCss')
 @yield('aditionalCss')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
      @include('includes.mainHeader')
      @include('includes.sideBar')

        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 0.0.1
    </div>
    <strong>Copyright &copy; 2021 <a href="#">Siaxe Technologies</a>.</strong> All rights
    reserved.
  </footer>
   @include('includes.basicJs')
   @yield('aditionalJs')
    </body>
</html>
@if (session('success'))
    <script>
        $( document ).ready(function() {
            Swal.fire("Success!", "{{ session('success') }}", "success");
        });
    </script>
@endif

@if (session('error'))
    <script>
        $( document ).ready(function() {
            Swal.fire("Oops!", "{{ session('error') }}", "error");
        });
    </script>
@endif
