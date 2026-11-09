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

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#111111">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#111111">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- CSS Files ================================================== -->
    <link href="{{ asset('assets/front/gemelli-garage/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="{{ asset('assets/front/gemelli-garage/css/plugins.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/front/gemelli-garage/css/swiper.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/front/gemelli-garage/css/style.css') }}" rel="stylesheet" type="text/css" >
    <link id="colors" href="{{ asset('assets/front/gemelli-garage/css/colors/scheme-1.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/front/gemelli-garage/css/custom-swiper-1.css') }}" rel="stylesheet" type="text/css" >

    <style>
        .lang-flag-img { width: 22px; height: 15px; border-radius: 3px; object-fit: cover; box-shadow: 0 1px 4px rgba(0,0,0,0.5); display: block; }
        .lang-flag { opacity: .5; transition: all .25s ease; display: inline-flex; align-items: center; padding: 2px; border-radius: 5px; text-decoration: none !important; }
        .lang-flag:hover { opacity: 0.9; transform: translateY(-1px); }
        .lang-flag.active { opacity: 1; border: 1.5px solid #28a745; box-shadow: 0 0 10px rgba(40,167,69,0.6); }
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
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="topbar-widget me-4 d-flex align-items-center gap-2">
                                        <a href="{{ route('language.switch', 'sq') }}" class="lang-flag {{ app()->getLocale() == 'sq' ? 'active' : '' }}" title="Shqip">
                                            <img src="{{ asset('country/al.svg') }}" alt="Shqip" class="lang-flag-img">
                                        </a>
                                        <a href="{{ route('language.switch', 'en') }}" class="lang-flag {{ app()->getLocale() == 'en' ? 'active' : '' }}" title="English">
                                            <img src="{{ asset('country/gb.svg') }}" alt="English" class="lang-flag-img">
                                        </a>
                                        <a href="{{ route('language.switch', 'it') }}" class="lang-flag {{ app()->getLocale() == 'it' ? 'active' : '' }}" title="Italiano">
                                            <img src="{{ asset('country/it.svg') }}" alt="Italiano" class="lang-flag-img">
                                        </a>
                                    </div>
                                    <div class="topbar-widget me-5"><a href="tel:+393248019211"><img src="{{ asset('assets/front/gemelli-garage/images/svg-white/phone.svg') }}" class="" alt="">{{ __('front.call_us') }}: +39 324 801 9211</a></div>
                                    <div class="topbar-widget"><a href="mailto:gemellicargarage@gmail.com"><img src="{{ asset('assets/front/gemelli-garage/images/svg-white/envelope.svg') }}" class="" alt="">{{ __('front.message_us') }}: gemellicargarage@gmail.com</a></div>
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
                                    <li><a class="menu-item" href="#about">{{ __('front.about') }}</a></li>
                                    <li><a class="menu-item" href="#services">{{ __('front.services') }}</a></li>
                                    <li><a class="menu-item" href="#contact">{{ __('front.contact') }}</a></li>
                                    <li class="d-md-none"><a class="menu-item text-color" href="{{ route('login') }}"><i class="fa fa-user-lock me-2"></i>{{ __('front.admin_login') }}</a></li>
                                </ul>
                                <!-- mainmenu end -->
                            </div>
                            <div class="de-flex-col">
                                <div class="menu_side_area">
                                    <a href="#configurator" class="btn-main fx-slide hover-white" x-on:click.prevent="scrollToConfigurator()"><span>{{ __('front.make_appointment') }}</span></a>
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
                  <h5>{{ __('front.working_hours') }}</h5>
                  <div class="mb-4">
                    <div class="d-flex justify-content-between text-white-50 border-bottom border-white/5 py-1"><span>{{ __('front.mon_fri') }}</span> <span class="text-white">08:00 - 13:00, 14:00 - 18:00</span></div>
                    <div class="d-flex justify-content-between text-white-50 border-bottom border-white/5 py-1"><span>{{ __('front.sat') }}</span> <span class="text-white">08:30 - 02:30</span></div>
                    <div class="d-flex justify-content-between text-white-50 py-1"><span>{{ __('front.sun') }}</span> <span class="text-white">{{ __('front.closed') }}</span></div>
                  </div>

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
                      <li><a href="{{ route('terms') }}">{{ __('front.terms') }}</a></li>
                      <li><a href="{{ route('privacy') }}">{{ __('front.privacy') }}</a></li>
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
            <h5>{{ __('front.working_hours') }}</h5>
            <div class="mb-4 text-sm">
                <div class="d-flex justify-content-between mb-1"><span>{{ __('front.mon_fri') }}:</span> <span class="text-white">08:00-13:00, 14:00-18:00</span></div>
                <div class="d-flex justify-content-between mb-1"><span>{{ __('front.sat') }}:</span> <span class="text-white">08:30-02:30</span></div>
                <div class="d-flex justify-content-between"><span>{{ __('front.sun') }}:</span> <span class="text-white">{{ __('front.closed') }}</span></div>
            </div>
            <h5>{{ __('front.contact') }}</h5>
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
