<!doctype html>
<html lang="en">
  <head>
    <title>Dominion | Retour à l'application</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/landing/fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{asset('assets/landing/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/owl.theme.default.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/landing/css/jquery.fancybox.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/landing/css/bootstrap-datepicker.css')}}">

    <link rel="stylesheet" href="{{asset('assets/landing/fonts/flaticon/font/flaticon.css')}}">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="{{asset('assets/landing/css/style.css')}}">
    <style>
        @keyframes bounce{
            from {transform: translateY(0);}
            to   {transform: translateY(-20px);}
        }
        .redirect {
            font-size: 3em;
            text-align: center;
            color:lightseagreen;
            animation-name: bounce;
            animation-duration: 0.4s;
            animation-iteration-count: infinite;
            animation-direction: alternate-reverse;
        }
    </style>
  </head>
  <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
  

  <!--<div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>-->


  <div class="site-wrap">

  
    
    <!--<header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">

      <div class="container">
        <div class="row align-items-center">
          
          <div class="col-6 col-xl-2">
            <h1 class="mb-0 site-logo"><a href="index.html" class="h2 mb-0">Nitro<span class="text-primary">.</span> </a></h1>
          </div>


        </div>
      </div>
      
    </header>-->

  
     
    <div class="site-blocks-cover overlay" style="background-image: url({{asset('assets/img/auth/payment.jpg')}});" data-aos="fade" id="home-section">

      <div class="container">
        <div class="row align-items-center justify-content-center">

          
          <div class="col-md-8 mt-lg-5 text-center">
            <h1 class="text-uppercase" data-aos="fade-up">Info</h1>
            @include('inc.messages')
            <p class="mb-5 desc"  data-aos="fade-up" data-aos-delay="100">Veuillez patienter un instant, vous allez être rediriger vers l'application ...</p>
            <div data-aos="fade-up" data-aos-delay="100">
              <!--<a href="#" class="btn smoothscroll btn-primary mr-2 mb-2" type="submit">Confirmer</a>-->
              <!--<form method="POST" action="#">
                <button type="submit" class="btn smoothscroll btn-primary mr-2 mb-2">Confirmer</button>
              </form>-->
              
            </div>
          </div>
            
        </div>
      </div>

    </div>  

    
    <!--<footer class="site-footer">
      <div class="container">
      
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <div class="border-top pt-5">
              <p>-->
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            <!--Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>-->
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
           <!--</p>
        
            </div>
          </div>
          
        </div>
      </div>-->
    <!--</footer>-->

  </div> <!-- .site-wrap -->

  <script language="javascript">

      var p = document.createElement('p');

      p.innerText = "Un instant nous terminons le processus...";

      p.className = "redirect";

      document.body.appendChild(p);
      
      setTimeout(() => {
          const message = 'message'
          const messageObj = {message: message}
          const stringifiedMessageObj = JSON.stringify(messageObj)
          if (window.webkit && window.webkit.messageHandlers) {
              //alert('postmessage call on webkit');
              window.webkit.messageHandlers.cordova_iab.postMessage(stringifiedMessageObj)
          } else {
              alert("Cliquez sur le bouton TERMINER en haut à droite de votre écran pour terminer le processus.");
          }
      }, 5000);
  </script>
  <script src="{{asset('assets/landing/js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('assets/landing/js/jquery-ui.js')}}"></script>
  <script src="{{asset('assets/landing/js/popper.min.js')}}"></script>
  <script src="{{asset('assets/landing/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/landing/js/owl.carousel.min.js')}}"></script>
  <script src="{{asset('assets/landing/js/jquery.countdown.min.js')}}"></script>
  <script src="{{asset('assets/landing/js/jquery.easing.1.3.js')}}"></script>
  <script src="js/aos.js"></script>
  <script src="{{asset('assets/landing/js/jquery.fancybox.min.js')}}"></script>
  <script src="{{asset('assets/landing/js/jquery.sticky.js')}}"></script>
  <script src="{{asset('assets/landing/js/isotope.pkgd.min.js')}}"></script>

  
  <script src="js/main.js"></script>
    
  </body>
</html>