<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Login | DOMINION</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="{{asset('assets/img/favicon.ico') }}" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/ionicons/dist/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/icon-kit/dist/css/iconkit.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{asset('assets/dist/css/theme.min.css') }}">
        <script src="{{asset('assets/src/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    </head>

    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="auth-wrapper">
            <div class="container-fluid h-100">
                <div class="row flex-row h-100 bg-white">
                    <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
                        <div class="lavalite-bg" style="background-image: url('assets/img/auth/login.jpg')">
                            <div class="lavalite-overlay"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                        <div class="authentication-form mx-auto">
                            <div class="logo-centered">
                                <a href="#"><img src="{{asset('assets/img/logo.png') }}" alt=""></a>
                            </div>
                            <h3>Se connecter à ADMIN DOMINION</h3>
                            <p>Heureux de vous revoir!</p>
                            <form method="POST" action="{{ route('login') }}">
                            	@csrf 
                                <div class="form-group">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <i class="ik ik-user"></i>
                                                    @error('email')
									                    <span class="invalid-feedback" role="alert">
									                        <strong>{{ $message}}</strong>
									                    </span>
									                @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Mot de passe" required autocomplete="current-password">
                                    <i class="ik ik-lock"></i>
				                                    @error('password')
									                    <span class="invalid-feedback" role="alert">
									                        <strong>{{ $message }}</strong>
									                    </span>
									                @enderror
                                </div>
                                <div class="row">
                                    <div class="col text-left">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span class="custom-control-label" for="remember">&nbsp;Se souvenir</span>
                                        </label>
                                    </div>
                                    <div class="col text-right">
                                         @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="sign-btn text-center">
                                    <button class="btn btn-theme" type="submit">Connexion</button>
                                </div>
                            </form>
                            <!--<div class="register">
                                <p>Vous n'avez pas de compte? <a href="{{ route('register') }}">Créer un compte</a></p>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js') }}"></script>
        <script>window.jQuery || document.write('<script src="{{asset('assets/src/js/vendor/jquery-3.3.1.min.js') }}"><\/script>')</script>
        <script src="{{asset('assets/plugins/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{asset('assets/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{asset('assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
        <script src="{{asset('assets/plugins/screenfull/dist/screenfull.js') }}"></script>
        <script src="{{asset('assets/dist/js/theme.js') }}"></script>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>
