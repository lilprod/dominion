<!doctype html>
<html class="no-js" lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Inscription| WASHMAN</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="../favicon.ico" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/ionicons/dist/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/icon-kit/dist/css/iconkit.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{asset('assets/dist/css/theme.min.css') }}">
        <script src="{{asset('src/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    </head>

    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="auth-wrapper">
            <div class="container-fluid h-100">
                <div class="row flex-row h-100 bg-white">
                    <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
                        <div class="lavalite-bg" style="background-image: url('assets/img/auth/register1.jpg')">
                            <div class="lavalite-overlay"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                        <div class="authentication-form mx-auto">
                            <div class="logo-centered">
                                <a href="#"><img src="../src/img/brand.svg" alt=""></a>
                            </div>
                            <h3>Nouvel inscrit sur ADMIN WASHMAN</h3>
                            <p>Rejoignez-nous maintenant!</p>
                            @include('inc.messages')
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-uppercase @error('name') is-invalid @enderror" placeholder="Nom" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    <i class="ik ik-user"></i>
                                    @error('name'))
							              <span class="invalid-feedback" role="alert">
							                  <strong>{{ $message }}</strong>
							              </span>
							        @enderror
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-capitalize @error('firstname') is-invalid @enderror" placeholder="Prénom" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname">
                                    <i class="ik ik-user"></i>

                                    @error('firstname'))
						              <span class="invalid-feedback" role="alert">
						                  <strong>{{ $message }}</strong>
						              </span>
						          	@enderror
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    <i class="ik ik-mail"></i>
                                    @error('email'))
						              <span class="invalid-feedback" role="alert">
						                  <strong>{{ $message }}</strong>
						              </span>
						          	@enderror
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Téléphone" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number">
                                    <i class="ik ik-phone"></i>
                                    @error('phone_number'))
						              <span class="invalid-feedback" role="alert">
						                  <strong>{{ $message }}</strong>
						              </span>
						          	@enderror
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Adresse" name="address" value="{{ old('address') }}" required autocomplete="address">
                                    <i class="ik ik-map"></i>
                                    @error('address'))
						              <span class="invalid-feedback" role="alert">
						                  <strong>{{ $message }}</strong>
						              </span>
						          	@enderror
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Mot de passe" name="password" required autocomplete="new-password">
                                    <i class="ik ik-lock"></i>
                                    @error('password'))
						              <span class="invalid-feedback" role="alert">
						                  <strong>{{ $message }}</strong>
						              </span>
						          	@enderror
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Confirmation mot de passe" name="password_confirmation" required autocomplete="new-password">
                                    <i class="ik ik-eye-off"></i>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-left">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="item_checkbox" name="item_checkbox" value="option1">
                                            <span class="custom-control-label">&nbsp;J'accepte les <a href="#">Termes and Conditions</a></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="sign-btn text-center">
                                    <button class="btn btn-theme" type="submit">Inscription</button>
                                </div>
                            </form>
                            <div class="register">
                                <p>Vous avez déjà un compte? <a href="{{ route('login') }}">Connexion</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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
