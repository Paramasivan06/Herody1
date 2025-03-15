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
                        <p class="subtitle">Our Team will contact you within 24 Hours</p>
                        
                        <form action="{{ route('bform.update') }}" method="post">
                            @csrf 
                            <div class="input-field">
                                <input id ="vname" name="vname" type="text" placeholder="Full Name">
                            </div>
                             <div class="input-field">
                                <input id ="cname" name="cname" type="text" placeholder="Company Name">
                            </div>
                            <div class="input-field">
                                <input id ="vemail" name="vemail" type="email" placeholder="Your Company Email Address">
                            </div>
                            <div class="input-field">
                                <input id ="vmobile" name="vmobile" type="text" placeholder="Mobile Number">
                            </div>
                            <div class="input-field">
                                <select name="area" id="area" required>
                                    <option>--- Select the Area of Work ---</option>
                                    <option value="User Acquisition - App/Website">User Acquisition - App/Website</option>
                                    <option value="Area Reviews">App Reviews</option>
                                    <option value="User Activation">User Activation</option>
                                    <option value="Sampling">Sampling</option>
                                    <option value="Affiliate Marketing">Affiliate Marketing</option>
                                    <option value="Influencer Marketing">Influencer Marketing</option>
                                    <option value="Social Media Marketing">Social Media Marketing</option>
                                    <option value="Campus Ambassador">Campus Ambassador</option>
                                    <option value="Campus Events">Campus Events</option>
                                    <option value="Campus Webinars">Campus Webinars</option>
                                    <option value="Telecalling">Telecalling</option>
                                    <option value="Lead Generation">Lead Generation</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                             <div class="input-field">
                                <input id ="msg" name="msg" type="text" placeholder="Explain your Requirement">
                            </div>
                            <div class="input-field">
                                <button id ="submit" name="submit" type="submit" class="template-btn">Submit <i class="fa-solid fa-long-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-7 col-md-10">
                    <div class="cta-content">
                        <div class="row ">
                            <div class="col-lg-10">
                                <div class="hero-content wow fadeInUp" data-wow-delay="0.3s">
                                    <h1 class="hero-title wow fadeInDown" data-wow-delay="0.3s">India’s Largest Distributed Network of Student Gig Workers</h1> <br>
                                    <h3 class="wow fadeInLeft" data-wow-delay="0.4s">Discover, Acquire, and Manage to Scale Your Business needs with Herody</h3><br>
                                    <p class="wow fadeInLeft" style="font-size:20px;">We offer solutions for User Acquisition, User Activation, Sampling, Affiliate Marketing, Campus Ambassadors, Campus Events, Telecalling, Lead Generation for Edtech & multiple other on-demand requirements on the go</p><br>
                                    <div class="counter-items row">
                                        <div class="col-lg-6">
                                            <div class="counter-item counter-black mt-40">
                                                <div class="counter-wrap"><span style="font-size: 30px;">400+</span></div>
                                                <h6 class="title font-montserrat" style="font-size: 25px;">Trusted by Brands</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="counter-item counter-black mt-40">
                                                <div class="counter-wrap"><span style="font-size: 30px;">20,000,000+</span></div>
                                                <h6 class="title font-montserrat" style="font-size: 25px;">Tasks Completed</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="counter-item counter-black mt-40">
                                                <div class="counter-wrap"><span style="font-size: 30px;">8000+</span></div>
                                                <h6 class="title font-montserrat" style="font-size: 20px;">Pincodes Presence</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="counter-item counter-black mt-40">
                                                <div class="counter-wrap"><span style="font-size: 30px;">2,50,000+</span></div>
                                                <h6 class="title font-montserrat" style="font-size: 20px;">Gig workers community</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<section class="work-process-section  section-gap overflow-hidden">
        <div class="container">
            <div class="section-heading text-center mb-30">
                <h2 class="title">Working Process</h2>
               
            </div>
            <div class="fancy-step-boxes">
                <div class="single-step-box wow fadeInUp" data-wow-delay="0.3s">
                    <div class="step-box-inner">
                        <div class="content">
                            <div class="icon">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            <h5 class="title">Propose Plan</h5>
                        </div>
                        <span class="step-count">01</span>
                    </div>
                </div>
                <div class="single-step-box wow fadeInUp" data-wow-delay="0.4s">
                    <div class="step-box-inner">
                        <div class="content">
                            <div class="icon">
                                <i class="flaticon-target"></i>
                            </div>
                            <h5 class="title">Publish Tasks</h5>
                        </div>
                        <span class="step-count">02</span>
                    </div>
                </div>
                <div class="single-step-box wow fadeInUp" data-wow-delay="0.5s">
                    <div class="step-box-inner">
                        <div class="content">
                            <div class="icon">
                                <i class="flaticon-diagnostic"></i>
                            </div>
                            <h5 class="title">Gigworkers Selection</h5>
                        </div>
                        <span class="step-count">03</span>
                    </div>
                </div>
                <div class="single-step-box wow fadeInUp" data-wow-delay="0.6s">
                    <div class="step-box-inner">
                        <div class="content">
                            <div class="icon">
                                <i class="flaticon-badge"></i>
                            </div>
                            <h5 class="title">Completely Managed</h5>
                        </div>
                        <span class="step-count">04</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="case-section bg-color-off-white section-gap overflow-hidden">
        <div class="container">
            <div class="section-heading text-center mb-30">
                <h2 class="title">Our Offerings</h2>
               
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="portfolio-items-one mt-30">
                        <div class="portfolio-thumb">
                            <img src="{{asset('assets/digital/assets/img/portfolio/01.jpg')}}" alt="Image">
                        </div>
                        <div class="portfolio-content">
                            <div class="categories">
                                 </div>
                            <h4 class="title"><a href="#">Brand Marketing</a></h4> &nbsp;
                            <p >Reach out to the audience to increase brand awareness via various activities</p>
                            <ul>
                                <li> <i class="fa-solid fa-circle-dot"></i> Campus Activation </li>
                                <li> <i class="fa-solid fa-circle-dot"></i> Social Media Engagement </li>
                                <li>  <i class="fa-solid fa-circle-dot"></i> Product Sampling </li>
                                <li> <i class="fa-solid fa-circle-dot"></i> User Acquisition</li>
                                <li> <i class="fa-solid fa-circle-dot"></i> Influencer Marketing</li>
                               
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="portfolio-items-one mt-30">
                        <div class="portfolio-thumb">
                            <img src="{{asset('assets/digital/assets/img/portfolio/02.jpg')}}" alt="Image">
                        </div>
                        <div class="portfolio-content">
                            <div class="categories">
                                 </div>
                            <h4 class="title"><a href="#">Business Development & Operations</a></h4> &nbsp;
                            <p>Optimize the cost of your Business Development with pay per outcome model</p>
                            <ul>
                                <li>  <i class="fa-solid fa-circle-dot"></i> Telecalling </li>
                                <li>  <i class="fa-solid fa-circle-dot"></i> Vendor Acquisition </li>
                                <li>  <i class="fa-solid fa-circle-dot"></i> Merchant Onboarding  </li>
                                <li>  <i class="fa-solid fa-circle-dot"></i> Data Entry </li>
                                <li>  <i class="fa-solid fa-circle-dot"></i> Field Sales </li>
                                <li> <i class="fa-solid fa-circle-dot"></i> Content & Data Operations</li>
                                <li>  <i class="fa-solid fa-circle-dot"></i> Transcription </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="portfolio-items-one mt-30">
                        <div class="portfolio-thumb">
                            <img src="{{asset('assets/digital/assets/img/portfolio/03.jpg')}}" alt="Image">
                        </div>
                        <div class="portfolio-content">
                            <div class="categories">
                                
                            </div>
                            <h4 class="title"><a href="#">Auditing & Market Research</a></h4>
                            <ul>
                                <li>  <i class="fa-solid fa-circle-dot"></i> Mystery Audit </li>
                                <li>  <i class="fa-solid fa-circle-dot"></i> Online Survey </li>
                                <li>  <i class="fa-solid fa-circle-dot"></i> Market Research </li>
                            </ul>

                        </div>
                    </div>
                </div>
              
            </div>
        </div>
    </section>
    <footer class="template-footer">
        <div class="container">
            <div class="footer-widgets-area">
                <div id="about" class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="widget contact-widget">
                            <h4 class="widget-title">About H<span style="color:orange;">erod</span>y</h4>
                            <div class="contact-content">
                               <p>Herody helps brands to scale their business by breaking down their complex business requirements into tasks and by taking end to end execution.</p>
                                <img width="75" height="75" src="{{asset('assets/digital/assets/img/logo.png')}}" alt="Herody">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div id="contact" class="widget contact-widget">
                            <h4 class="widget-title">Contact Us</h4>
                           <div class="contact-content">
                                <div class="phone-number">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <p> 4th Floor, Classic Converge, 17th Cross Road, Sector 6, HSR Layout, Bengaluru, Karnataka 560102.</p>
                                </div>
                                <div class="phone-number">
                                    <i class="fa-solid fa-envelope"></i>
                                    <p>help@herody.in</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget newsletters-widget pl-xl-4">
                            <h4 class="widget-title">Businesses</h4>
                            <p>
                                For any business releated queries reach us out at <strong>raj@herody.in</strong> 
                            </p>
                            <ul class="social-links">
                                <li><span>Follow Us: </span></li>
                               <li><a href="https://www.facebook.com/herodywebsite"><i class="fa-brands fa-facebook-square"></i></a></li>
                                 <li><a href="https://www.instagram.com/herodyapp/"><i class="fa-brands fa-instagram-square"></i></a></li>
                                <li><a href="https://www.linkedin.com/company/herody/"><i class="fa-brands fa-linkedin"></i></a></li>
                            </ul><br>
                            <h3 class="widget-title"><a href="https://herody.in/refund-policy">Refund Policy</a></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-box">
                Copyright @2024 <a href="https://herody.in">Jaketa Media & Entertainment Private Limited</a>. All Right Reserved.
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