<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Chorale Saint Jean Paul II </title>
    <!-- Favicon-->
    <link rel="icon" href="cssdste/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="cssdste/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="cssdste/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="cssdste/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="cssdste/css/style.css" rel="stylesheet">

</head>

<body class="signup-page">
    <center style="border-radius: 10px; margin-left: 50%; z-index: 1; left: 50%;top: 75%; transform: translate(-50%, 15%); width: 360px;"> @include('flash-message')</center> 
    <div class="signup-box">
        <div class="logo">
            <a href="javascript:void(0);">{{config('app.name')}}</a>
            <small></small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_up" method="POST" action="{{ route('loginS') }}">
                    <div class="msg">Modifier mon mot de passe</div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="libelle" value="modifier" />
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="login" placeholder="Identifiant" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="ancien_pass" placeholder="Ancien mot de passe" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="new_pass" minlength="6" placeholder="Nouveau mot de passe" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="confir_pass" minlength="6" placeholder="Confirmer nouveau mot de passe" required>
                        </div>
                    </div>

                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">Valider</button>

                    <div class="m-t-25 m-b--5 align-center">
                        <a href="{{ route('login') }}">Se connecter</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="cssdste/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="cssdste/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="cssdste/node-waves/waves.js"></script>

    <!-- Custom Js -->
    <script src="cssdste/js/admin.js"></script>

    <!-- Validation Plugin Js -->
    <script src="cssdste/jquery-validation/jquery.validate.js"></script>

    <script src="cssdste/examples/sign-up.js"></script>
</body>

</html>