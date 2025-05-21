<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Favicon -->
<link rel="stylesheet" href="{{asset('images/favicon.ico')}}"/>

<!-- bootstrap -->
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>

<!-- flaticon -->
<link rel="stylesheet" href="{{asset('css/flaticon.css')}}"/>

<!-- mega menu -->
<link rel="stylesheet" href="{{asset('css/mega-menu/mega_menu.css')}}"/>

<!-- font awesome -->
<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}"/>

<!-- owl-carousel -->
<link rel="stylesheet" href="{{asset('css/owl-carousel/owl.carousel.css')}}"/>

<!-- magnific-popup -->
<link rel="stylesheet" href="{{asset('css/magnific-popup/magnific-popup.css')}}"/>


<!-- revolution -->
<link rel="stylesheet" href="{{asset('revolution/css/settings.css')}}"/>

<!-- main style -->
<link rel="stylesheet" href="{{asset('css/style.css')}}"/>

<!-- responsive -->
<link rel="stylesheet" href="{{asset('css/responsive.css')}}"/>


</head>
<body>
   @include('front-end.components.feature-car')





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
