<x-layouts.guest>
    <section class="jarallax" style="min-height: 40vh; padding: 100px 0;">
        <img src="{{ asset('assets/front/gemelli-garage/images/background/4.webp') }}" class="jarallax-img" alt="">
        <div class="sw-overlay"></div>
        <div class="container relative z-3">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="text-uppercase">{{ __('front.terms') }}</h1>
                    <div class="spacer-20"></div>
                    <div class="subtitle">{{ config('app.name') }}</div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="p-40 bg-dark-2 rounded-1 text-light">
                        {!! __('front.terms_content') !!}

                        <div class="spacer-30"></div>
                        <a href="{{ route('home') }}" class="btn-main fx-slide"><span><i class="fa fa-arrow-left me-2"></i> {{ __('front.home') }}</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.guest>
