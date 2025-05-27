<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themes.potenzaglobalsolutions.com/html/cardealer/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 May 2025 11:17:54 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="HTML5 Template" />
<meta name="description" content="Car Dealer - The Best Car Dealer Automotive Responsive HTML5 Template" />
<meta name="author" content="potenzaglobalsolutions.com" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title>@yield('title')</title>


    <!-- Favicon -->
<link rel="stylesheet" href="{{asset('images/favicon.ico')}}"/>

<!-- bootstrap -->
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>

<!-- flaticon -->
<link rel="stylesheet" href="{{asset('css/flaticon.css')}}"/>

<!-- mega menu -->
<link rel="stylesheet" href="{{asset('css/mega-menu/mega_menu.css')}}"/>

<!-- font awesome -->
{{-- <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}"/> --}}

<!-- owl-carousel -->
<link rel="stylesheet" href="{{asset('css/owl-carousel/owl.carousel.css')}}"/>

<!-- magnific-popup -->
{{-- <link rel="stylesheet" href="{{asset('css/magnific-popup/magnific-popup.css')}}"/> --}}


<!-- revolution -->
<link rel="stylesheet" href="{{asset('revolution/css/settings.css')}}"/>

<!-- main style -->
<link rel="stylesheet" href="{{asset('css/style.css')}}"/>

<!-- responsive -->
<link rel="stylesheet" href="{{asset('css/responsive.css')}}"/>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
{{-- @vite(['resources/js/app.js', 'resources/css/app.css']) --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


</head>
<body>
<!--=================================
 header -->

<header id="header" class="defualt">
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="topbar-left text-lg-start text-center">
                    <ul class="list-inline">
                <li> <i class="fa-solid fa-envelope"> </i> support@website.com</li>



                <li> <i class="fa-solid fa-clock"></i> Mon - Sat 8.00 - 18.00. Sunday CLOSED</li>
            </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="topbar-right text-lg-end text-center">
                        <ul class="list-inline">
                <li> <i class="fa fa-phone"></i> (007) 123 456 7890</li>
                <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
            </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--=================================
    mega menu -->

    <div class="menu">
    <!-- menu start -->
        <nav id="menu" class="mega-menu">
            <!-- menu list items container -->
            <section class="menu-list-items">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 position-relative">
                            <!-- menu logo -->
                            <ul class="menu-logo">
                                <li>
                                    <a href="{{route('home.index')}}"><img id="logo_img" src="{{asset('images/logo-light.png')}}" alt="logo"> </a>
                                </li>
                            </ul>
                            <!-- menu links -->
                            <ul class="menu-links">
                                <!-- active class -->
                                <li class="active"><a href="javascript:void(0)">Home <i class="fa-solid fa-angle-down"></i></a>
                                    <!-- drop down full width -->
                                    <div class="drop-down menu-bg grid-col-12">
                                        <!--grid row-->
                                        <div class="grid-row">
                                            <!--grid column 3-->
                                            <div class="grid-col-3">
                                                <div class="menu-heading">Home Modern</div>
                                                <ul>
                                                <li><a href="modern-home-1.html">Home Modern 1 <span class="label-new">New</span></a></li>
                                                <li><a href="modern-home-2.html">Home Modern 2 <span class="label-new">New</span></a></li>
                                                <li><a href="modern-home-3.html">Home Modern 3 <span class="label-new">New</span></a></li>
                                                <li><a href="electro-home.html">Home Electro <span class="label-new">New</span></a></li>
                                                <li><a href="#">Coming Soon...</a></li>
                                                </ul>
                                            </div>
                                            <!--grid column 3-->
                                            <div class="grid-col-3">
                                                <div class="menu-heading">Home Classic</div>
                                                <ul>
                                                <li class="active"><a href="index.html">Home 01</a></li>
                                                <li><a href="index-2.html">Home 02</a></li>
                                                <li><a href="index-3.html">Home 03</a></li>
                                                <li><a href="index-4.html">Home 04</a></li>
                                                <li><a href="index-5.html">Home 05</a></li>
                                                </ul>
                                            </div>
                                            <!--grid column 3-->
                                            <div class="grid-col-3">
                                                <div class="menu-heading">Home Classic</div>
                                                <ul>
                                                <li><a href="index-6.html">Home 06</a></li>
                                                <li><a href="index-7.html">Home 07</a></li>
                                                <li><a href="index-8.html">Home 08</a></li>
                                                <li><a href="index-9.html">Home 09</a></li>
                                                <li><a href="index-10.html">Home 10</a></li>
                                                </ul>
                                            </div>
                                            <!--grid column 3-->
                                            <div class="grid-col-3">
                                                <div class="menu-heading">Home Classic</div>
                                                <ul>
                                                    <li><a href="index-car-service.html">Car service </a></li>
                                                    <li><a href="index-car-directory.html">Car directory</a></li>
                                                    <li><a href="index-car-listing.html">Car listing </a></li>
                                                    <li><a href="index-landing-page.html">landing page</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li><a href="javascript:void(0)">Pages <i class="fa-solid fa-angle-down"></i></a>
                                    <!-- drop down full width -->
                                    <div class="drop-down menu-bg grid-col-12">
                                        <!--grid row-->
                                        <div class="grid-row">
                                            <!--grid column 3-->
                                            <div class="grid-col-3">
                                                <ul>
                                                <li><a href="about-01.html">About 01</a></li>
                                                <li><a href="about-02.html">About 02</a></li>
                                                <li><a href="about-modern.html">About Modern <span class="label-new">New</span></a></li>
                                                <li><a href="service-01.html">service 01</a></li>
                                                <li><a href="service-02.html">service 02</a></li>
                                                <li><a href="services-modern.html">Services Modern <span class="label-new">New</span></a></li>
                                                </ul>
                                            </div>
                                            <!--grid column 3-->
                                            <div class="grid-col-3">
                                                <ul>
                                                <li><a href="team-01.html">team 01</a></li>
                                                <li><a href="team-02.html">team 02</a></li>
                                                <li><a href="team-single.html">Team Single <span class="label-new">New</span></a></li>
                                                <li><a href="contact-01.html">contact 01</a></li>
                                                <li><a href="contact-02.html">contact 02</a></li>
                                                <li><a href="contact-modern.html">Contact Modern <span class="label-new">New</span></a></li>
                                                </ul>
                                            </div>
                                            <!--grid column 3-->
                                            <div class="grid-col-3">
                                                <ul>
                                                <li><a href="career.html">career</a></li>
                                                <li><a href="faq.html">faq</a></li>
                                                <li><a href="login.html">login</a></li>
                                                <li><a href="register.html">register</a></li>
                                                <li><a href="error-404.html">error 404</a></li>
                                                <li><a href="coming-soon.html">coming soon</a></li>
                                                </ul>
                                            </div>
                                            <!--grid column 3-->
                                            <div class="grid-col-3">
                                                <ul>
                                                <li><a href="typography.html">typography</a></li>
                                                <li><a href="page-left-sidebar.html">page left sidebar </a></li>
                                                <li><a href="page-right-sidebar.html">page right sidebar </a></li>
                                                <li><a href="page-both-sidebar.html">page both sidebar </a></li>
                                                <li><a href="terms-and-conditions.html">terms and conditions </a></li>
                                                <li><a href="privacy-policy.html">privacy policy </a></li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </li>
                                <li><a href="javascript:void(0)">blog <i class="fa-solid fa-angle-down"></i></a>
                                    <!-- drop down multilevel  -->
                                    <ul class="drop-down-multilevel">
                                        <li><a href="javascript:void(0)">blog classic <i class="fa-solid fa-angle-right"></i></a>
                                            <!-- drop down second level -->
                                            <ul class="drop-down-multilevel">
                                            <li><a href="blog-left-sidebar.html">left sidebar</a></li>
                                            <li><a href="blog-right-sidebar.html">right sidebar</a></li>
                                            <li><a href="blog-fullwidth.html">fullwidth</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:void(0)">Masonry  <i class="fa-solid fa-angle-right"></i></a>
                                        <!-- drop down second level -->
                                            <ul class="drop-down-multilevel">
                                                <li><a href="blog-masonry-2-collums.html"> 2 column </a> </li>
                                                <li><a href="blog-masonry-3-collums.html"> 3 column </a> </li>
                                                <li><a href="blog-masonry-4-collums.html"> 4 column </a> </li>
                                                <li><a href="blog-masonry-left-sidebar.html">left sidebar</a></li>
                                            <li><a href="blog-masonry-right-sidebar.html">right sidebar</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:void(0)">blog single <i class="fa-solid fa-angle-right"></i></a>
                                        <!-- drop down second level -->
                                            <ul class="drop-down-multilevel">
                                                <li><a href="blog-single-01.html">blog single 01 </a> </li>
                                                <li><a href="blog-single-02.html">blog single 02 </a> </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)">Car listing  <i class="fa-solid fa-angle-down"></i></a>
                                <!-- drop down multilevel  -->
                                    <ul class="drop-down-multilevel">
                                        <li><a href="{{route('car.index')}}">listing 01</a></li>
                                        <li><a href="listing-02.html">listing 02</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)">Car details  <i class="fa-solid fa-angle-down"></i></a>
                                <!-- drop down multilevel  -->
                                    <ul class="drop-down-multilevel">
                                        <li><a href="details-01.html">details 01</a></li>
                                        <li><a href="details-02.html">details 02</a></li>
                                        <li><a href="vehicle-view-360.html">Vehicle View 360° <span class="label-new">New</span></a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)"> Contact <i class="fa-solid fa-angle-down"></i></a>
                                    <!-- drop down multilevel  -->
                                    <ul class="drop-down-multilevel right-menu">
                                    <li><a href="contact-01.html">contact 01</a></li>
                                    <li><a href="contact-02.html">contact 02</a></li>
                                    <li><a href="contact-modern.html">Contact Modern <span class="label-new">New</span></a></li>
                                    </ul>
                                </li>
                                <li>
                                <div class="search-top">
                                    <a class="search-btn not_click d-none d-lg-block" href="javascript:void(0);">
                                        <i class="fa-solid fa-search"></i>
                                    </a>
                                    <div class="search-box not-click">
                                    <div class="row">
                                        <div class="col-xl-2 col-md-4 col-sm-6">
                                        <div class="selected-box">
                                        <select class="selectpicker">
                                        <option>Make </option>
                                        <option>BMW</option>
                                        <option>Honda </option>
                                        <option>Hyundai </option>
                                        <option>Nissan </option>
                                        <option>Mercedes Benz </option>
                                        </select>
                                        </div>
                                        </div>
                                        <div class="col-xl-2 col-md-4 col-sm-6">
                                        <div class="selected-box">
                                            <select class="selectpicker">
                                            <option>Model</option>
                                            <option>3-Series</option>
                                            <option>Carrera</option>
                                            <option>GT-R</option>
                                            <option>Cayenne</option>
                                            <option>Mazda6</option>
                                            <option>Macan</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="col-xl-2 col-md-4 col-sm-6">
                                        <div class="selected-box">
                                        <select class="selectpicker">
                                            <option>Year</option>
                                            <option>2010</option>
                                            <option>2011</option>
                                            <option>2012</option>
                                            <option>2013</option>
                                            <option>2014</option>
                                            <option>2015</option>
                                            <option>2016</option>
                                        </select>
                                        </div>
                                            </div>
                                        <div class="col-xl-2 col-md-4 col-sm-6">
                                            <div class="selected-box">
                                            <select class="selectpicker">
                                                <option>Body style</option>
                                                <option>2dr Car</option>
                                                <option>4dr Car</option>
                                                <option>Convertible</option>
                                                <option>Sedan</option>
                                                <option>Sports Utility</option>
                                            </select>
                                            </div>
                                            </div>
                                        <div class="col-xl-2 col-md-4 col-sm-6">
                                            <div class="selected-box">
                                            <select class="selectpicker">
                                                <option>Vehicle Status</option>
                                                <option>Condition</option>
                                                <option>All Conditions</option>
                                                <option>Condition</option>
                                                <option>Brand New</option>
                                                <option>Slightly Used</option>
                                                <option>Used</option>
                                            </select>
                                            </div>
                                            </div>
                                        <div class="col-xl-2 col-md-4 col-sm-6">
                                            <div class="text-center">
                                            <button class="button red" type="button">Search</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </nav>
        <!-- menu end -->
    </div>
</header>


<!--=================================
 header -->

 @yield('content')


 <!--=================================
 footer -->

<footer class="footer bg-2 bg-overlay-black-90">
  <div class="container">
    <div class="row">
    <div class="col-md-12">
        <div class="social">
        <ul>
            <li><a class="facebook nav-link hover:text-gray-100" href="#">facebook <i class="fa-brands fa-facebook"></i> </a></li>
            <li><a class="twitter nav-link hover:text-gray-100" href="#">twitter <i class="fa-brands fa-twitter"></i> </a></li>
            <li><a class="pinterest nav-link hover:text-gray-100" href="#">pinterest <i class="fa-brands fa-pinterest-p"></i> </a></li>
            <li><a class="dribbble nav-link hover:text-gray-100" href="#">dribbble <i class="fa-brands fa-dribbble"></i> </a></li>
            <li><a class="google-plus nav-link hover:text-gray-100" href="#">google plus <i class="fa-brands fa-google-plus"></i> </a></li>
            <li><a class="behance nav-link hover:text-gray-100" href="#">behance <i class="fa-brands fa-behance"></i> </a></li>
        </ul>
        </div>
    </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="about-content">
          <img class="img-fluid" id="logo-footer" src="{{asset('images/logo-light.png')}}" alt="">
          <p>We provide everything you need to build an amazing dealership website developed especially for car sellers dealers or auto motor retailers.</p>
        </div>
        <div class="address">
          <ul>
            <li> <i class="fa fa-map-marker"></i><span>220E Front St. Burlington NC 27215</span> </li>
            <li> <i class="fa fa-phone"></i><span>(007) 123 456 7890</span> </li>
            <li> <i class="fa-solid fa-envelope"></i><span>support@website.com</span> </li>
          </ul>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="usefull-link">
        <h6 class="text-white">Useful Links</h6>
          <ul>
            <li><a href="#"><i class="fa fa-angle-double-right"></i> Change Oil and Filter</a></li>
            <li><a href="#"><i class="fa fa-angle-double-right"></i> Brake Pads Replacement</a></li>
            <li><a href="#"><i class="fa fa-angle-double-right"></i> Timing Belt Replacement</a></li>
            <li><a href="#"><i class="fa fa-angle-double-right"></i> Pre-purchase Car Inspection</a></li>
            <li><a href="#"><i class="fa fa-angle-double-right"></i> Starter Replacement</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
       <div class="recent-post-block">
        <h6 class="text-white">recent posts </h6>
          <div class="recent-post">
            <div class="recent-post-image">
              <img class="img-fluid" src="{{asset('images/car/01.jpg')}}" alt="">
            </div>
            <div class="recent-post-info">
                <a href="#">Time to change your </a>
                <span class="post-date"><i class="fa fa-calendar"></i>September 10, 2021</span>
            </div>
         </div>
         <div class="recent-post">
            <div class="recent-post-image">
              <img class="img-fluid" src="{{asset('images/car/02.jpg')}}" alt="">
            </div>
            <div class="recent-post-info">
                <a href="#">The best time to </a>
                <span class="post-date"><i class="fa fa-calendar"></i>September 10, 2021</span>
            </div>
         </div>
         <div class="recent-post">
            <div class="recent-post-image">
              <img class="img-fluid" src="{{asset('images/car/03.jpg')}}" alt="">
            </div>
            <div class="recent-post-info">
                <a href="#">Replacing a timing </a>
                <span class="post-date"><i class="fa fa-calendar"></i>September 10, 2021</span>
            </div>
         </div>
       </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="news-letter">
        <h6 class="text-white">subscribe Our Newsletter </h6>
         <p>Keep up on our always evolving products features and technology. Enter your e-mail and subscribe to our newsletter.</p>
         <form class="news-letter">
           <input type="email" placeholder="Enter your Email" class="form-control placeholder">
           <a class="button red" href="#">Subscribe</a>
         </form>
        </div>
      </div>
    </div>
    <hr />
    <div class="copyright">
     <div class="row">
      <div class="col-lg-6 col-md-12">
       <div class="text-lg-start text-center">
        <p>©Copyright 2021 Car Dealer Developed by <a href="http://www.potenzaglobalsolutions.com/" target="_blank">Potenzaglobalsolutions</a></p>
       </div>
      </div>
      <div class="col-lg-6 col-md-12">
        <ul class="list-inline text-lg-end text-center">
          <li><a href="#">privacy policy </a> | </li>
          <li><a href="#">terms and conditions </a> |</li>
          <li><a href="#">contact us </a></li>
        </ul>
      </div>
     </div>
    </div>
  </div>
</footer>

<!--=================================
 footer -->

 <!--=================================
 back to top -->

<div class="car-top">
  <span><img src="{{asset('images/car.png')}}" alt=""></span>
</div>

    <!--=================================
 jquery -->

<!-- jquery  -->
<script type="text/javascript" src="{{asset('js/jquery-3.6.0.min.js')}}"></script>

<!-- bootstrap -->
<script type="text/javascript" src="{{asset('js/popper.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>

<!-- mega-menu -->
<script type="text/javascript" src="{{asset('js/mega-menu/mega_menu.js')}}"></script>

<!-- appear -->
<script type="text/javascript" src="{{asset('js/jquery.appear.js')}}"></script>

<!-- counter -->
<script type="text/javascript" src="{{asset('js/counter/jquery.countTo.js')}}"></script>

<!-- owl-carousel -->
<script type="text/javascript" src="{{asset('js/owl-carousel/owl.carousel.min.js')}}"></script>

<!-- select -->
<script type="text/javascript" src="{{asset('js/select/jquery-select.js')}}"></script>

<!-- magnific popup -->
<script type="text/javascript" src="{{asset('js/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

<!-- revolution -->
<script type="text/javascript" src="{{asset('revolution/js/jquery.themepunch.tools.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
<script type="text/javascript" src="{{asset('revolution/js/extensions/revolution.extension.actions.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revolution/js/extensions/revolution.extension.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revolution/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revolution/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revolution/js/extensions/revolution.extension.migration.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revolution/js/extensions/revolution.extension.navigation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revolution/js/extensions/revolution.extension.parallax.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revolution/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
<script type="text/javascript" src="{{asset('revolution/js/extensions/revolution.extension.video.min.js')}}"></script>

<!-- custom -->
<script type="text/javascript" src="{{asset('js/custom.js')}}"></script>

<script type="text/javascript">
   (function($){
  "use strict";

    var tpj=jQuery;
      var revapi2;
      tpj(document).ready(function() {
        if(tpj("#rev_slider_2_1").revolution == undefined){
          revslider_showDoubleJqueryError("#rev_slider_2_1");
        }else{
          revapi2 = tpj("#rev_slider_2_1").show().revolution({
            sliderType:"standard",
            sliderLayout:"fullwidth",
            dottedOverlay:"none",
            delay:9000,
            navigation: {
              keyboardNavigation:"off",
              keyboard_direction: "horizontal",
              mouseScrollNavigation:"off",
                             mouseScrollReverse:"default",
              onHoverStop:"off",
              bullets: {
                enable:true,
                hide_onmobile:false,
                style:"hermes",
                hide_onleave:false,
                direction:"horizontal",
                h_align:"center",
                v_align:"bottom",
                h_offset:0,
                v_offset:50,
                                space:10,
                tmp:''
              }
            },
            visibilityLevels:[1240,1024,778,480],
            gridwidth:1570,
            gridheight:1000,
            lazyType:"none",
            shadow:0,
            spinner:"spinner3",
            stopLoop:"off",
            stopAfterLoops:-1,
            stopAtSlide:-1,
            shuffle:"off",
            autoHeight:"off",
            disableProgressBar:"on",
            hideThumbsOnMobile:"off",
            hideSliderAtLimit:0,
            hideCaptionAtLimit:0,
            hideAllCaptionAtLilmit:0,
            debugMode:false,
            fallbacks: {
              simplifyAll:"off",
              nextSlideOnWindowFocus:"off",
              disableFocusListener:false,
            }
          });
        }
      });
  })(jQuery);

</script>
</body>
</html>
