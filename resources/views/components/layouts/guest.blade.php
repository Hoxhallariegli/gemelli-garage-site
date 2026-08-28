<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ __('front.meta_title') }}</title>
    <link rel="icon" href="{{ asset('assets/front/gemelli-garage/images/icon.webp') }}" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <meta content="{{ __('front.meta_description') }}" name="description" >
    <meta content="" name="keywords" >
    <meta content="" name="author" >

    <!-- CSS Files ================================================== -->
    <link href="{{ asset('assets/front/gemelli-garage/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="{{ asset('assets/front/gemelli-garage/css/plugins.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/front/gemelli-garage/css/swiper.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/front/gemelli-garage/css/style.css') }}" rel="stylesheet" type="text/css" >
    <link id="colors" href="{{ asset('assets/front/gemelli-garage/css/colors/scheme-1.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/front/gemelli-garage/css/custom-swiper-1.css') }}" rel="stylesheet" type="text/css" >

    <style>
        .size-20px { width: 20px; height: auto; border-radius: 2px; }
        .lang-flag { opacity: .4; transition: all .3s ease; display: flex; align-items: center; }
        .lang-flag:hover, .lang-flag.active { opacity: 1; transform: scale(1.1); }
        .lang-flag.active { border-bottom: 2px solid #28a745; padding-bottom: 2px; }
    </style>

    @livewireStyles
</head>

<body class="dark-scheme">
    <div id="wrapper">
        <a href="#" id="back-to-top"></a>

        <!-- preloader begin -->
        <div id="de-loader"></div>
        <!-- preloader end -->

        <!-- header begin -->
        <header class="transparent">
            <div id="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between xs-hide">
                                <div class="d-flex">
                                    <div class="topbar-widget"><a href="#"><img src="{{ asset('assets/front/gemelli-garage/images/svg-white/bell.svg') }}" class="" alt="">{{ __('front.topbar_promo') }}</a></div>
                                </div>
                                <div class="d-flex">
                                    <div class="topbar-widget me-4 d-flex align-items-center gap-2">
                                        <a href="{{ route('language.switch', 'sq') }}" class="lang-flag {{ app()->getLocale() == 'sq' ? 'active' : '' }}" title="Shqip">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 980 700" class="size-20px"><path fill="#e41e20" d="M0 0h980v700H0z"/><path d="M490 148l24 48 43-26-8 49 50 4-33 38 31 39-49-7-14 49-14-49-49 7 31-39-33-38 50-4-8-49 43 26 24-48z"/></svg>
                                        </a>
                                        <a href="{{ route('language.switch', 'en') }}" class="lang-flag {{ app()->getLocale() == 'en' ? 'active' : '' }}" title="English">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" class="size-20px"><path fill="#012169" d="M0 0h60v30H0z"/><path stroke="#fff" stroke-width="6" d="M0 0l60 30M60 0L0 30"/><path stroke="#C8102E" stroke-width="4" d="M0 0l60 30M60 0L0 30"/><path stroke="#fff" stroke-width="10" d="M30 0v30M0 15h60"/><path stroke="#C8102E" stroke-width="6" d="M30 0v30M0 15h60"/></svg>
                                        </a>
                                        <a href="{{ route('language.switch', 'it') }}" class="lang-flag {{ app()->getLocale() == 'it' ? 'active' : '' }}" title="Italiano">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3 2" class="size-20px"><path fill="#009246" d="M0 0h1v2H0z"/><path fill="#fff" d="M1 0h1v2H1z"/><path fill="#ce2b37" d="M2 0h1v2H2z"/></svg>
                                        </a>
                                    </div>
                                    <div class="topbar-widget me-5"><a href="#"><img src="{{ asset('assets/front/gemelli-garage/images/svg-white/phone.svg') }}" class="" alt="">{{ __('front.call_us') }}: +39 324 801 9211</a></div>
                                    <div class="topbar-widget"><a href="#"><img src="{{ asset('assets/front/gemelli-garage/images/svg-white/envelope.svg') }}" class="" alt="">{{ __('front.message_us') }}: gemellicargarage@gmail.com</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="de-flex sm-pt10">
                            <div class="de-flex-col">
                                <!-- logo begin -->
                                <div id="logo">
                                    <a href="/">
                                        <img class="logo-main" src="{{ asset('assets/front/gemelli-garage/images/logo-gemelli.png') }}" alt="" style="height: 60px;">
                                        <img class="logo-mobile" src="{{ asset('assets/front/gemelli-garage/images/logo-gemelli.png') }}" alt="" style="height: 50px;">
                                    </a>
                                </div>
                                <!-- logo end -->
                            </div>
                            <div class="de-flex-col header-col-mid">
                                <!-- mainemenu begin -->
                                <ul id="mainmenu">
                                    <li><a class="menu-item" href="/">{{ __('front.home') }}</a></li>
                                    <li><a class="menu-item" href="#services">{{ __('front.services') }}</a></li>
                                    <li><a class="menu-item" href="#about">{{ __('front.about') }}</a></li>
                                    <li><a class="menu-item" href="#contact">{{ __('front.contact') }}</a></li>
                                </ul>
                                <!-- mainmenu end -->
                            </div>
                            <div class="de-flex-col">
                                <div class="menu_side_area">
                                    <a href="#vehicle-selection" class="btn-main fx-slide hover-white"><span>{{ __('front.make_appointment') }}</span></a>
                                    <span id="menu-btn"></span>
                                </div>

                                <div id="btn-extra">
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header end -->

        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            {{ $slot }}
        </div>
        <!-- content end -->

        <!-- footer begin -->
        <footer>
          <div class="container">
            <div class="row gx-5">
              <div class="col-lg-4 col-sm-6">
                <img src="{{ asset('assets/front/gemelli-garage/images/logo-gemelli.png') }}" class="logo-footer" alt="" style="height: 100px;">
                <div class="spacer-20"></div>
                <p>{{ __('front.footer_about') }}</p>

                <div class="social-icons mb-sm-30">
                  <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                  <a href="https://instagram.com/gemellicargarage"><i class="fa-brands fa-instagram"></i></a>
                  <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
              </div>

              <div class="col-lg-4 col-sm-12 order-lg-1 order-sm-2">
                <div class="row">
                  <div class="col-lg-5">
                    <div class="widget">
                      <h5>{{ __('front.company') }}</h5>
                      <ul>
                        <li><a href="/">{{ __('front.home') }}</a></li>
                        <li><a href="#services">{{ __('front.services') }}</a></li>
                        <li><a href="#about">{{ __('front.about') }}</a></li>
                        <li><a href="#contact">{{ __('front.contact') }}</a></li>
                      </ul>
                    </div>
                  </div>

                  <div class="col-lg-7">
                    <div class="widget">
                      <h5>{{ __('front.our_services') }}</h5>
                      <ul>
                        <li><a href="#">{{ __('front.tinting') }}</a></li>
                        <li><a href="#">{{ __('front.light_tinting') }}</a></li>
                        <li><a href="#">{{ __('front.wrapping') }}</a></li>
                        <li><a href="#">{{ __('front.polishing') }}</a></li>
                        <li><a href="#">{{ __('front.detailing') }}</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-sm-6 order-lg-2 order-sm-1">
                <div class="widget">
                  <h5>{{ __('front.contact') }}</h5>

                  <div class="fw-bold text-white">
                    <i class="icofont-location-pin me-2 id-color"></i>{{ __('front.legal_office') }}
                  </div>
                  Viale della repubblica 30, Melegnano 20077

                  <div class="spacer-20"></div>

                  <div class="fw-bold text-white">
                    <i class="icofont-phone me-2 id-color"></i>{{ __('front.call_us') }}
                  </div>
                  +39 324 801 9211

                  <div class="spacer-20"></div>

                  <div class="fw-bold text-white">
                    <i class="icofont-envelope me-2 id-color"></i>{{ __('front.message_us') }}
                  </div>
                  gemellicargarage@gmail.com
                </div>
              </div>
            </div>
          </div>

          <div class="subfooter">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="de-flex">
                    <div class="de-flex-col">
                      &copy; {{ date('Y') }} - Gemelli Car Garage by E4ProTech
                    </div>
                    <ul class="menu-simple">
                      <li><a href="#">{{ __('front.terms') }}</a></li>
                      <li><a href="#">{{ __('front.privacy') }}</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </footer>
        <!-- footer end -->
    </div>

    <!-- overlay content begin -->
    <div id="extra-wrap" class="text-light">
        <div id="btn-close">
            <span></span>
            <span></span>
        </div>

        <div id="extra-content">
            <img src="{{ asset('assets/front/gemelli-garage/images/logo-gemelli.png') }}" class="w-150px" alt="">
            <div class="spacer-30-line"></div>
            <h5>{{ __('front.premium_services') }}</h5>
            <ul class="ul-check">
              <li>{{ __('front.tinting') }}</li>
              <li>{{ __('front.light_tinting') }}</li>
              <li>{{ __('front.wrapping') }}</li>
              <li>{{ __('front.polishing') }}</li>
              <li>{{ __('front.detailing') }}</li>
            </ul>
            <div class="spacer-30-line"></div>
            <h5>{{ __('front.contact') }}</h5>
            <div><i class="icofont-clock-time me-2 op-5"></i>{{ __('front.working_hours') }}</div>
            <div><i class="icofont-location-pin me-2 op-5"></i>{{ __('front.location') }}</div>
            <div class="social-icons mt-4">
                <a href="https://instagram.com/gemellicargarage"><i class="fa-brands fa-instagram"></i></a>
            </div>
            <div class="spacer-30-line"></div>
            <a href="{{ route('login') }}" class="btn-main fx-slide hover-white w-100 text-center"><span>{{ __('front.admin_login') }}</span></a>
        </div>
    </div>

    <!-- Javascript Files ================================================== -->
    <script src="{{ asset('assets/front/gemelli-garage/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/front/gemelli-garage/js/designesia.js') }}"></script>
    <script src="{{ asset('assets/front/gemelli-garage/js/swiper.js') }}"></script>
    <script src="{{ asset('assets/front/gemelli-garage/js/custom-swiper-2.js') }}"></script>

    @livewireScripts
</body>
</html>
