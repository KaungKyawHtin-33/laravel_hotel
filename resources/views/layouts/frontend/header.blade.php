<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/animate.css') }}">
    
    <link rel="stylesheet" href="{{ URL::asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/aos.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/jquery.timepicker.css') }}">

    
    <link rel="stylesheet" href="{{ URL::asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/frontend.style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/reservation.css') }}">

    <!-- PNotify -->
    <link href="{{ URL::asset('assets/pnotify/dist/pnotify.css" rel="stylesheet') }}">
    <link href="{{ URL::asset('assets/pnotify/dist/pnotify.buttons.css" rel="stylesheet') }}">
    <link href="{{ URL::asset('assets/pnotify/dist/pnotify.nonblock.css" rel="stylesheet') }}">

    {{-- Jquery --}}
    <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/angular.min.js') }}"></script>

  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="javascript:void(0)">Hotel<span>Booking</span></a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
	          <li class="nav-item"><a href="rooms.php" class="nav-link">Our Rooms</a></li>
	          <li class="nav-item"><a href="about.html" class="nav-link">About Us</a></li>
	          <li class="nav-item"><a href="contact_us.php" class="nav-link">Contact</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->

    <div class="hero">
        <section class="home-slider owl-carousel">
            <div class="slider-item" style="background-image:url('assets/images/bg_1.jpg');">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-end">
                        <div class="col-md-6 ftco-animate">
                            <div class="text">
                                <h2>More than a hotel... an experience</h2>
                                <h1 class="mb-3">Hotel for the whole family, all year round.</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="slider-item" style="background-image:url('assets/images/bg_2.jpg');">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-end">
                        <div class="col-md-6 ftco-animate">
                            <div class="text">
                                <h2>Harbor Lights Hotel &amp; Resort</h2>
                                <h1 class="mb-3">It feels like staying in your own home.</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</div>