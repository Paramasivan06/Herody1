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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        .grand-modal .modal-content {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.2);
            padding: 20px;
            position: relative;
        }
    
        .grand-modal .modal-header {
            border-bottom: none;
            padding-bottom: 10px;
            background: #f7f7f7;
        }
    
        .grand-modal .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }
    
        .job-section h6 {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
        }
    
        .job-section ul {
            padding-left: 20px;
        }
    
        .job-section ul li {
            font-size: 1rem;
            margin-bottom: 0.6rem;
            color: #333;
        }
    
        .modal-footer .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 8px 20px;
        }
        .job-grid-layout {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        .job-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 768px) {
            .job-grid-layout {
                grid-template-columns: repeat(2, 1fr); /* 2 columns on medium screens */
            }
        }

        @media (min-width: 992px) {
            .job-grid-layout {
                grid-template-columns: repeat(3, 1fr); /* 3 columns on large screens */
            }
        }
       

    </style>
       
</head>

<body>
    <!--====== Start Preloader ======-->
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
                            <img width="75" height="75" src="{{asset('assets/digital/assets/img/logo.png')}}" alt="Tilke">
                        </a>
                    </div>
                    <nav class="nav-menu d-none d-xl-block">
                        <ul class="primary-menu">
                             <li>
                                <a href="https://herody.in">Home</a>
                                
                            </li>
                            <li>
                                <a href="https://herody.in/gigworkers">Gigworkers</a>
                               
                            </li>
                            <li>
                                <a  href="https://herody.in/businesses">Businesses</a>
                               
                            </li>
                            <li>
                                <a href="https://herody.in/#about">About</a>
                                
                            </li>
                            <li>
                                <a class="active" href="">Career</a>
                                
                            </li>
                            <li>
                                <a href="https://herody.in/#contact">Contact</a>
                               
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="header-right">
                    <ul class="header-extra">
                        <li class="header-btns d-none d-md-block">
                            <a href="https://play.google.com/store/apps/details?id=com.jaketa.herody" class="template-btn">
                                Get Started
                                <i class="fa-solid fa-long-arrow-right"></i>
                            </a>
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
                                <a href="https://herody.in">Home</a>
                                
                            </li>
                            <li>
                                <a class="" href="https://herody.in/gigworkers">Gigworkers</a>
                               
                            </li>
                            <li>
                                <a  href="https://herody.in/businesses">Businesses</a>
                               
                            </li>
                        <li>
                            <a href="#about">About</a>
                            
                        </li>
                        <li>
                            <a class="active" href="">Career</a>
                            
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
    <section class="career-section section-gap">
        <div class="container">
            <div class="row align-items-center justify-content-between">
    
                <!-- Left Side: About the Company (only show if there's one job) -->
                <!--@if ($jobs->count() === 1)-->
                <!--    <div class="col-xl-6 col-lg-6 col-md-12 d-flex align-items-center">-->
                <!--        <div class="career-content content-mb-lg-80">-->
                <!--            <div class="section-heading mb-20">-->
                <!--                <div class="header-left d-flex align-items-center">-->
                <!--                    <div class="pl-3">-->
                <!--                        <h2 class="title">Herody</h2>-->
                <!--                        <p class="location">Bangalore, Karnataka</p>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--            <p>At Herody, we help businesses grow by offering scalable solutions through our gig workforce...</p>-->
                <!--            <p>Join us in transforming the gig economy and creating opportunities across the country...</p>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--@endif-->
    
                <!-- Right Side: Job Vacancy Details -->
                <div class="col-12">
                    <div class="career-content content-mb-lg-80">
                        <div class="section-heading mb-20">
                            <h2 class="title">Current Job Vacancies</h2>
                            <p class="tagline">We're looking for talented individuals to join our team</p>
                        </div>
    
                        <!-- Job Listings Grid -->
                        <div class="job-grid-layout">
                            @foreach($jobs as $job)
                                <div class="job-card">
                                    <ul class="vacancy-list">
                                        <li><strong>Position:</strong> {{ $job->position }}</li>
                                        <li><strong>Location:</strong> {{ $job->location }}</li>
                                        <li><strong>CTC:</strong> {{ $job->pay }} + Incentives</li>
                                        <li><strong>Job type:</strong> {{ $job->job_type }}</li>
                                        <li><strong>Shift:</strong> {{ $job->shift }}</li>
                                    </ul>
                                    <div class="input-field mt-2">
                                        <!-- Button to open modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jobDetailsModal{{ $job->id }}">Apply Now</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Job Vacancy Modal -->
        @foreach ($jobs as $job)
            <div class="modal fade grand-modal" id="jobDetailsModal{{ $job->id }}" tabindex="-1" aria-labelledby="jobDetailsModalLabel{{ $job->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="jobDetailsModalLabel{{ $job->id }}">
                                <i class="fas fa-chart-line"></i> {{ $job->position }} - Job Details
                            </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Close</button>

                        </div>
                        <div class="modal-body">
                            <div class="job-section mb-3">
                                <h6><i class="fas fa-briefcase"></i> Job Overview</h6>
                                <p><strong>Position:</strong> {{ $job->position }}</p>
                                <p><strong>Location:</strong> {{ $job->location }}</p>
                                <p><strong>CTC:</strong> {{ $job->pay }}</p>
                                <p><strong>Job type:</strong> {{ $job->job_type }}</p>
                                <p><strong>Shift:</strong> {{ $job->shift }}</p>
                            </div>
                            <div class="job-section mb-3">
                                <h6><i class="fas fa-tasks"></i> Job description</h6>
                                <ul>
                                    @foreach(explode(',', $job->responsibilities) as $responsibility)
                                        <li>{!! trim($responsibility) !!}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('jobs.apply') }}" class="btn btn-secondary">Apply</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
    
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>

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
                                    <p>raj@herody.in</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget newsletters-widget pl-xl-4">
                            <h4 class="widget-title">Businesses</h4>
                            <p>
                                For any business releated queries reach us out at <strong><a class="info-title" href="sales@herody.in">raj@herody.in</a></strong>
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
                Copyright @2024 <a href="https://herody.in">Jaketa Media & Entertainment Private Limited</a>. All Right Reserved.
            </div>
        </div>
    </footer>
    <!--====== Template Footer End ======-->
<div class="modal" id="Modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Fill the Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="consultation-form consultation-style-two">
                        <h3 class="title">Get in Touch with Us!</h3>
                        <p class="subtitle">Our Team may contact you within 24 Hours.</p>
                        <form action="#">
                            <div class="input-field">
                                <input type="text" placeholder="Full Name">
                            </div>
                             <div class="input-field">
                                <input type="text" placeholder="Company Name">
                            </div>
                            <div class="input-field">
                                <input type="text" placeholder="Your Company Email Address">
                            </div>
                            <div class="input-field">
                                <input type="text" placeholder="Mobile Number">
                            </div>
                            <div class="input-field">
                                <input type="text" placeholder="Area of Work">
                            </div>
                             <div class="input-field">
                                <input type="text" placeholder="Explain your Requirement">
                            </div>
                            <div class="input-field">
                                <button type="submit" class="template-btn">Submit <i class="fa-solid fa-long-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
      </div>
     
    </div>
  </div>
</div>

    <!--====== Jquery ======-->
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