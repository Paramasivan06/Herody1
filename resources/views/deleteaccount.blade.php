<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Herody, A Gig Worker Platform enabling businesses to get their work done by using our Gigwork force.">
  <meta name="keywords" content="Gigs, Projects, Internships, Herody, Businesses, Gigworkers">
  <meta name="author" content="Herody">
 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herody </title>
    <link rel="canonical" href="https://herody.in/"/>
    <link rel="shortcut icon" href="{{asset('assets/main/images/Viti.png')}}">
    <!--====== Animate Css ======-->
    <link rel="stylesheet" href="{{asset('assets/digital/assets/css/animate.min.css')}}" />
    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{asset('assets/digital/assets/css/bootstrap.min.css')}}" />
    <!--====== Slick Slider ======-->
    <link rel="stylesheet" href="{{asset('assets/digital/assets/css/slick.min.css')}}" />
    <!--====== Nice Select ======-->
    <link rel="stylesheet" href="{{asset('assets/digital/assets/css/nice-select.min.css')}}" />
    <!--====== Font Awesome ======-->
    <script src="https://kit.fontawesome.com/27d8faf608.js" crossorigin="anonymous"></script>
    <!--====== Flaticon ======-->
    <link rel="stylesheet" href="{{asset('assets/digital/assets/fonts/flaticon/css/flaticon.css')}}" />
    <!--====== Lity CSS ======-->
    <link rel="stylesheet" href="{{asset('assets/digital/assets/css/lity.min.css')}}" />
    <!--====== Main Css ======-->
    <link rel="stylesheet" href="{{asset('assets/digital/assets/css/style.css')}}" />
    <!--====== Responsive CSS ======-->
    <link rel="stylesheet" href="{{asset('assets/digital/assets/css/responsive.css')}}" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Archivo&display=swap');
        .hero-area-three .hero-content .hero-title {
    font-family: Archivo;
    font-size: 68px;
        letter-spacing: 0em;
    text-align: left;
    color: #272D4E;
    padding-bottom: 7%;
    font-style: normal;
    font-weight: 600;
    line-height: 88px;
}
    </style>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Q1TFE7Z5PC"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-Q1TFE7Z5PC');
</script>
</head>

<body>
    
 <div id="preloader">
        <div id="loading-center">
            <div id="object"></div>
        </div>
    </div>
    <!--====== End Preloader ======-->

    <!--====== Start Header ======-->
    <header class="template-header absolute-header navbar-left sticky-header">
        <div class="topbar">
            <p>Let's make something great together.</p>
        </div>
        <div class="container">
            <div class="header-inner">
                <div class="header-left">
                    <div class="site-logo">
                        <a href="https://herody.in">
                            <img width="75" height="75" src="{{asset('assets/digital/assets/img/logo.png')}}" alt="Business Form">
                        </a>
                    </div>
                    <nav class="nav-menu d-none d-xl-block">
                        <ul class="primary-menu">
                           <li>
                                <a class="active" href="https://herody.in">Home</a>
                                
                            </li>
                            <li>
                                <a  href="https://herody.in/gigworkers">Gigworkers</a>
                               
                            </li>
                            <li>
                                <a  href="https://herody.in/businesses">Businesses</a>
                               
                            </li>
                            <li>
                                <a href="#about">About</a>
                                
                            </li>
                            <li>
                                <a href="#contact">Contact</a>
                               
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="header-right">
                    <ul class="header-extra">
                        <li class="header-btns d-none d-md-block">
                            <button type="button" class="template-btn" data-toggle="modal" data-target="#Modal">
  Get Started <i class="fa-solid fa-long-arrow-right"></i>
</button>
                        </li>
                        <li class="d-xl-none">
                            <div class="navbar-toggler">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div class="slide-panel mobile-slide-panel">
            <div class="panel-overlay"></div>
            <div class="panel-inner">
                <div class="panel-logo">
                    
                </div>
                <nav class="mobile-menu">
                    <ul class="primary-menu">
                        <li>
                                <a class="active" href="https://herody.in">Home</a>
                                
                            </li>
                            <li>
                                <a  href="https://herody.in/gigworkers">Gigworkers</a>
                               
                            </li>
                            <li>
                                <a  href="https://herody.in/businesses">Businesses</a>
                               
                            </li>
                        <li>
                            <a href="#about">About</a>
                            
                        </li>
                        <li>
                            <a href="#contact">Contact</a>
                           
                        </li>
                    </ul>
                </nav>
                <a href="#" class="panel-close">
                    <i class="fa-solid fa-times"></i>
                </a>
            </div>
        </div>
    </header>
    <!--====== End Header ======-->
    <section>&nbsp;</section>
    <section class="skill-section section-gap bg-color-primary-7 bg-cover-center" style="background-image: url({{asset('assets/digital/assets/img/service-bg.jpg')}});">
    <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 order-lg-last">
                    
                <div class="consultation-form consultation-style-two">
                        <h3 class="title">Get in Touch with Us!</h3>
                        <p class="subtitle">Our Team may contact you within 24 Hours</p>
                        
                        <form method="POST" name="google-sheet">
                            @csrf 
                            <div class="input-field">
                                <input id ="vname" name="name" type="text" placeholder="Full Name">
                            </div>
                             <div class="input-field">
                                <input id ="vemail" name="email" type="email" placeholder="Email Address">
                            </div>
                            <div class="input-field">
                                <input id ="vmobile" name="mobile" type="number" placeholder="Mobile Number">
                            </div>
                            <div class="input-field">
                                <input id ="vusername" name="username" type="text" placeholder="User Name">
                            </div>
                            <div class="input-field">
                                <button id ="submit" name="submit" type="submit" class="template-btn">Submit <i class="fa-solid fa-long-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                
    </section>
    <script>
            const scriptURL = 'https://script.google.com/macros/s/AKfycbxw8ALUvRM2hzqS77l1aFs3gjxl1SlGoaP8EANrSX-cK3fnZ0nGF5YAjo7UdxHRiQpE/exec'
            const form = document.forms['google-sheet']
          
            form.addEventListener('submit', e => {
              e.preventDefault()
              fetch(scriptURL, { method: 'POST', body: new FormData(form)})
                .then(response => alert("Thanks for Contacting us..! We Will Contact You Soon..."))
                .catch(error => console.error('Error!', error.message))
            })
          </script>
 <footer class="template-footer">
        <div class="container">
            <div class="footer-widgets-area">
                <div id="about" class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="widget contact-widget">
                            <h4 class="widget-title">About Us</h4>
                            <div class="contact-content">
                               <p>Herody helps brands to scale their business by breaking down their complex business requirements into tasks and by taking end to end execution.</p>
                                <p> #39, 2nd Floor, NGEF Lane, Indiranagar, Bangalore-560038.</p>
                                <img width="75" height="75" src="{{asset('assets/digital/assets/img/logo.png')}}" alt="Herody">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div id="contact" class="widget contact-widget">
                            <h4 class="widget-title">Contact Us</h4>
                           <div class="contact-content">
                                <div class="phone-number">
                                    <span>Phone Number</span>
                                    <a href="tel:02269124061">
                                        <i class="fa-solid fa-phone"></i>
                                        02269124061
                                    </a>
                                </div>
                                <div class="phone-number">
                                    <span>Email Address</span>
                                    <a href="mailto:help@herody.in">
                                        <i class="fa-solid fa-envelope"></i>
                                       help@herody.in
                                    </a>
                                </div>
                               
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget newsletters-widget pl-xl-4">
                            <h4 class="widget-title">Businesses</h4>
                            <p>
                                For any business releated queries reach us out at <a class="info-title" href="sales@herody.in">sales@herody.in</a>
                            </p>
                           
                            <ul class="social-links">
                                <li><span>Follow Us: </span></li>
                               <li><a href="https://www.facebook.com/herodywebsite"><i class="fa-brands fa-facebook-square"></i></a></li>
                                 <li><a href="https://www.instagram.com/herodyapp/"><i class="fa-brands fa-instagram-square"></i></a></li>
                                <li><a href="https://www.linkedin.com/company/herody/"><i class="fa-brands fa-linkedin"></i></a></li>
                            
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-box">
                Copyright @2023 <a href="https://herody.in">Jaketa Media & Entertainment Private Limited</a>. All Right Reserved.
            </div>
        </div>
    </footer>

    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{asset('assets/digital/assets/js/jquery-3.6.0.min.js')}}"></script>
    <!--====== Bootstrap ======-->
    <script src="{{asset('assets/digital/assets/js/bootstrap.min.js')}}"></script>
    <!--====== Slick slider ======-->
    <script src="{{asset('assets/digital/assets/js/slick.min.js')}}"></script>
    <!--====== Isotope ======-->
    <script src="{{asset('assets/digital/assets/js/isotope.pkgd.min.js')}}"></script>
    <!--====== Imagesloaded ======-->
    <script src="{{asset('assets/digital/assets/js/imagesloaded.pkgd.min.js')}}"></script>
    <!--====== Inview ======-->
    <script src="{{asset('assets/digital/assets/js/jquery.inview.min.js')}}"></script>
    <!--====== Easypiechart ======-->
    <script src="{{asset('assets/digital/assets/js/jquery.easypiechart.min.js')}}"></script>
    <!--====== Nice Select ======-->
    <script src="{{asset('assets/digital/assets/js/jquery.nice-select.min.js')}}"></script>
    <!--====== Lity CSS ======-->
    <script src="{{asset('assets/digital/assets/js/lity.min.js')}}"></script>
    <!--====== WOW Js ======-->
    <script src="{{asset('assets/digital/assets/js/wow.min.js')}}"></script>
    <!--====== Main JS ======-->
    <script src="{{asset('assets/digital/assets/js/main.js')}}"></script>
</body>

</html>