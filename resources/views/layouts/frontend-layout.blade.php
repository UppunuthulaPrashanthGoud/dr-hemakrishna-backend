<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- Site Metas -->
      <title>@yield('title', 'Prashanth Goud')</title>
      <meta name="keywords" content="@yield('keywords', '')">
      <meta name="description" content="@yield('description', '')">
      <meta name="author" content="@yield('author', '')">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css') }}">
      <!-- Custom Style CSS -->
      <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css') }}">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
      <!-- Favicon -->
      <link rel="icon" href="{{ asset('frontend/images/fevicon.png') }}" type="image/gif">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="{{ asset('frontend/css/jquery.mCustomScrollbar.min.css') }}">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- Owl Carousel CSS -->
      <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
      <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">
      <!-- Fancybox CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   </head>

   @php
    $settings = DB::table('general_settings')->first();
@endphp
   <body>
      <!-- Header Section -->
      <div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <div class="logo">
                  <a href="{{ url('/') }}"><img src="{{ asset($settings->header_logo) }}" height="80" alt="Logo"></a>
               </div>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                     <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ url('/gallery') }}">Gallery</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ url('/contact') }}">Contact Us</a>
                     </li>
                  </ul>
               </div>
            </nav>
         </div>
      </div>

      <!-- Main Content -->
      <div class="content">
         @yield('content')
      </div>

     <!--footer section start -->
     <div class="footer_section">
         <div class="container">
            <h1 class="touch_text">Get In Touch</h1>
            <div class="email_box">
               <div class="input_main">
                  <form action="/action_page.php">
                     <div class="form-group">
                        <input type="text" class="email-bt" placeholder="Name" name="Name">
                     </div>
                     <div class="form-group">
                        <input type="text" class="email-bt" placeholder="Phone" name="Phone">
                     </div>
                     <div class="form-group">
                        <input type="text" class="email-bt" placeholder="Email" name="Email">
                     </div>
                     <div class="form-group">
                        <textarea class="massage-bt" placeholder="Massage" rows="5" id="comment" name="Massage"></textarea>
                     </div>
                  </form>
                  <div class="send_bt"><a href="#">SEND</a></div>
               </div>
            </div>
            <div class="call_main">
               <div class="call_text"><img src="images/call-icon.png"><span class="padding_left_15">Call Now  +01 123467890</span></div>
               <div class="call_text"><img src="images/mail-icon.png"><span class="padding_left_15">demo@gmail.com</span></div>
            </div>
            <div class="social_icon">
               <ul>
                  <li><a href="#"><img src="images/fb-icon.png"></a></li>
                  <li><a href="#"><img src="images/twitter-icon.png"></a></li>
                  <li><a href="#"><img src="images/linkedin-icon.png"></a></li>
                  <li><a href="#"><img src="images/instagram-icon.png"></a></li>
               </ul>
            </div>
         </div>
      </div>
      <!--footer section end -->
      <!--copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text"> 2023 All Rights Reserved. Design By <a href="https://prashanthgoud.in">Uppunuthula Prashanth Goud</a></p>
         </div>
      </div>
      <!--copyright section end -->


      <!-- Javascript Files -->
      <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
      <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
      <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('frontend/js/jquery-3.0.0.min.js') }}"></script>
      <script src="{{ asset('frontend/js/plugin.js') }}"></script>
      <!-- Sidebar -->
      <script src="{{ asset('frontend/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
      <script src="{{ asset('frontend/js/custom.js') }}"></script>
      <!-- Owl Carousel -->
      <script src="{{ asset('frontend/js/owl.carousel.js') }}"></script>
      <!-- Fancybox -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
   </body>
</html>
