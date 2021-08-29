<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Log in | Restaurant Management</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('includes.basicCss')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <b>Restaurant Management</b>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to RMS</p>

            <form id="loginForm">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="User Name" name="user_name" form="loginForm">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password" form="loginForm">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12" id="loginFormErrors">

                    </div>
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-primary btn-block btn-flat FormSubmit"
                            data-form="loginForm">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <script type="text/javascript">
        baseUrl = "{{ url('login') }}";
    </script>
    @include('includes.basicJs')
    <script type="text/javascript">
        function submitSuccess(data) {
            var datahtml = '<p class="text-success">' + data + '</p>';
            $("#" + formId + "Errors").html(datahtml);

            window.location = '{{ route('dashboard') }}/';

        }
    </script>

</body>

</html>
