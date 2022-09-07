<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Toys 4 Joy</title>
<link rel="icon" href="{{asset('website/img/logo-t4j.png')}}" type="image/x-icon">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{asset('website/js/animate/animate.min.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<!--
<link href="{{asset('website/plugins/mmenu/mmenu.css')}}" rel="stylesheet">
<link href="{{asset('website/plugins/mhead-menu/mhead.css')}}" rel="stylesheet">
<link href="{{asset('website/plugins/b-multiselect/bootstrap-multiselect.min.css')}}" rel="stylesheet">-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css"> 
<!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>-->
<link href="{{asset('website/css/buttons-fancy.css')}}?v=<?=md5_file(public_path('website/css/buttons-fancy.css')); ?>" rel="stylesheet">
<link href="{{asset('website/css/buttons-animated.css')}}?v=<?=md5_file(public_path('website/css/buttons-animated.css')); ?>" rel="stylesheet">
<link href="{{asset('website/css/footer.css')}}?v=<?=md5_file(public_path('website/css/footer.css')); ?>" rel="stylesheet">
<link href="{{asset('website/css/style.css')}}?v=<?=md5_file(public_path('website/css/style.css')); ?>" rel="stylesheet">
<link rel='stylesheet' href='https://unpkg.com/xzoom/dist/xzoom.css'>    

@stack('otherstyle')
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-E5P76SM8E3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-E5P76SM8E3');
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-58BNJ88');</script>
<!-- End Google Tag Manager -->


<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1199770164191927');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1199770164191927&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
<meta name="facebook-domain-verification" content="8365pig04unbnybla9i6f5r5z0189u" />
</head>
<body>


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N8WPWL4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@include('website.layouts.header')
    @yield('content')
@include('website.layouts.footer')

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.2.0/jquery-migrate.min.js" integrity="sha512-5O0jzCJTmTO9ylmof+eDShChXs+Y0GncP7fXqEq1jQQ7KwoIALwLIleE4ritPTgfuWEALFmXOTeXopcLMQ8X8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--lazy loader-->
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
<script type="text/javascript" src="{{asset('website/js/owl-carousel-2.3.4/js/owl.carousel.js')}}"></script>
<script type="text/javascript" src="{{asset('website/js/owl-carousel-2.3.4/js/owl.autoplay.js')}}"></script>
<script type="text/javascript" src="{{asset('website/js/owl-carousel-2.3.4/js/owl.animate.js')}}"></script>
<script type="text/javascript" src="{{asset('website/js/owl-carousel-2.3.4/js/owl.navigation.js')}}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-1b93190375e9ccc259df3a57c1abc0e64599724ae30d7ea4c6877eb615f89387.js"></script>
<script src='https://unpkg.com/xzoom/dist/xzoom.min.js'></script>
<script src='https://hammerjs.github.io/dist/hammer.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/js/foundation.min.js'></script>  
<script type="text/javascript" src="{{asset('website/js/zoomsl/zoomsl.min.js')}}"></script>
<!--mobile menu-->
<!--<script type="text/javascript" src="{{asset('website/plugins/mmenu/mmenu.js')}}"></script>   
<script type="text/javascript" src="{{asset('website/plugins/mhead-menu/mhead.js')}}"></script>   
<script type="text/javascript" src="{{asset('website/plugins/b-multiselect/bootstrap-multiselect.min.js')}}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script> 
<!--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>-->
<!--<script type="text/javascript" src="{{asset('website/js/buttons-animated.js')}}?v=<?php //md5_file(public_path('website/js/buttons-animated.js')); ?>"></script> --> 
<script type="text/javascript" src="{{asset('website/js/custom.js')}}?v=<?=md5_file(public_path('website/js/custom.js')); ?>"></script>   
        <script>
        $(document).ready(function() {
            toastr.options.timeOut = 10000; 
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif(Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif          
        });

    </script>
     <script>
             $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
/*document.addEventListener(
        "DOMContentLoaded", () => {
            const menu =  new Mmenu( "nav#menu-mobile", {
                "theme": "dark-contrast"
            },{
    // CSS classes
    classNames: {
      divider:"Divider",
      inset:"Inset",
      panel:"Panel",
      selected:"Selected",
      spacer:"Spacer",
      vertical:"Vertical"
        } 
    }) 
            const api = menu.API;

            document.querySelector( "#open-menu-mobile" )
                .addEventListener(
                    "click", () => {
                        api.open();
                    }
                );
           
      });*/

    
    </script>
@stack('otherscript')

</body>
</html>
