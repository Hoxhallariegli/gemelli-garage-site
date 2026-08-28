<div>
    <style>
        /* GEMELLI PREMIUM SYNC - NO TAILWIND TRASH */

        /* 1. Reset & Sync Input Styles */
        #contact .relative input[type="text"],
        #contact .form-control,
        #configurator .form-control {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(40, 167, 69, 0.3) !important; /* Subtle Green Border */
            color: #fff !important;
            border-radius: 0px !important;
            height: 50px !important;
            padding: 10px 15px !important;
            font-size: 14px !important;
            font-weight: 400 !important;
            box-shadow: none !important;
            width: 100% !important;
            transition: all 0.3s ease;
        }

        #contact input:focus,
        #contact .form-control:focus,
        #configurator .form-control:focus {
            border-color: #28a745 !important;
            background: rgba(40, 167, 69, 0.1) !important;
            outline: none !important;
        }

        /* 3. Section Headers Sync */
        .gem-form-group {
            margin-bottom: 25px;
        }

        .gem-form-group h5 {
            color: #fff !important;
            font-size: 13px !important;
            letter-spacing: 2px;
            margin-bottom: 15px !important;
            text-transform: uppercase;
        }

        /* 4. Premium Price Box */
        .price-estimate-container {
            background: rgba(40, 167, 69, 0.05);
            border-left: 3px solid #28a745;
            padding: 20px;
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* 5. Wizard Selection Cool Styles */
        .wizard-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 20px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            border-radius: 4px;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .wizard-card:hover {
            background: rgba(40, 167, 69, 0.05);
            border-color: rgba(40, 167, 69, 0.3);
            transform: translateY(-5px);
        }

        .wizard-card.active {
            background: rgba(40, 167, 69, 0.1);
            border-color: #28a745;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.2);
        }

        .wizard-card img {
            width: 100%;
            height: auto;
            max-width: 150px;
            margin-bottom: 15px;
            filter: grayscale(1) brightness(0.8);
            transition: all 0.5s ease;
        }

        .wizard-card:hover img,
        .wizard-card.active img {
            filter: grayscale(0) brightness(1);
            transform: scale(1.05);
        }

        .wizard-card h4 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            font-weight: 900;
            color: #666;
            transition: color 0.3s ease;
        }

        .wizard-card:hover h4,
        .wizard-card.active h4 {
            color: #28a745;
        }

        /* Material/Color Specific */
        .material-swatch {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-bottom: 10px;
            border: 2px solid rgba(255,255,255,0.1);
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }

        .step-dot.active {
            background: #28a745;
            box-shadow: 0 0 10px #28a745;
            width: 20px;
            border-radius: 4px;
        }

        /* 6. Back Button Premium Sync */
        .btn-back {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            padding: 8px 20px !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
            font-weight: 700 !important;
            letter-spacing: 2px !important;
            border-radius: 0px !important;
            transition: all 0.3s ease !important;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            text-decoration: none !important;
        }

        .btn-back:hover {
            background: rgba(40, 167, 69, 0.1) !important;
            border-color: #28a745 !important;
            color: #28a745 !important;
        }
    </style>

    <div wire:ignore wire:key="landing-static-part">
        <div id="top"></div>

        <section class="jarallax" style="min-height: 100vh;">
            <img src="{{ asset('assets/front/gemelli-garage/images/background/4.webp') }}" class="jarallax-img" alt="">
            <div class="sw-overlay"></div>
            <div class="gradient-edge-bottom"></div>
            <div class="container relative z-3">
                <div class="spacer-double"></div>
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h1 class="fs-72 fs-xs-10vw text-uppercase wow fadeInUp">{{ __('front.subtitle') }}</h1>
                        <p class="mb-0 col-lg-6 offset-lg-3 wow fadeInUp" data-wow-delay=".2s">{{ __('front.description') }}</p>
                        <div class="spacer-single"></div>
                        <a class="btn-main fx-slide" href="#configurator" x-on:click.prevent="document.getElementById('configurator').scrollIntoView({ behavior: 'smooth' })"><span>{{ __('front.configure_now') }}</span></a>
                    </div>

                    <div class="spacer-single"></div>

                    <div class="col-lg-12">
                        <img src="{{ asset('assets/front/gemelli-garage/images/misc/c2.webp') }}" class="w-100" alt="">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 lg:py-24 pt-0" id="services">
            <div class="container">
                <div class="row justify-content-center mb-8 lg:mb-12">
                    <div class="col-lg-6 text-center px-4">
                        <div class="subtitle text-[10px] lg:text-xs">{{ __('front.our_services') }}</div>
                        <h2 class="text-3xl lg:text-5xl">{{ __('front.premium_detailing') }}</h2>
                        <p class="text-gray-400 text-sm lg:text-base">{{ __('front.choose_treatment') }}</p>
                    </div>
                </div>

                <div class="row g-3 lg:g-4">
                    @foreach($services as $index => $service)
                    <div class="col-12 col-sm-6 col-md-4" wire:key="service-card-{{ $service->id }}">
                        <div class="hover rounded-2xl overflow-hidden relative text-light text-center transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/10">
                            @if($service->image)
                                <img src="{{ asset($service->image) }}" class="hover-scale-1-1 w-100 object-cover h-56 lg:h-72" alt="{{ $service->name }}">
                            @else
                                <img src="{{ asset('assets/front/gemelli-garage/images/services-2/'.(($index % 4) + 1).'.webp') }}" class="hover-scale-1-1 w-100 h-56 lg:h-72 object-cover" alt="">
                            @endif

                            <div class="abs w-100 px-4 z-4 abs-centered opacity-0 hover:opacity-100 transition-opacity duration-500">
                                <button type="button" class="btn-main fx-slide w-full"
                                    wire:click="toggleService({{ $service->id }}); $wire.goToStep(2);"
                                    x-on:click="document.getElementById('configurator').scrollIntoView({ behavior: 'smooth' })">
                                    <span>{{ __('front.add_to_quote') }}</span>
                                </button>
                            </div>

                            <h3 class="abs fs-24 lg:fs-32 lh-1 p-4 top-0 start-0 z-2 opacity-50">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</h3>
                            <div class="abs bg-black/40 backdrop-blur-[2px] z-2 top-0 w-100 h-100 opacity-0 hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="sw-overlay op-8"></div>

                            <div class="abs z-2 bottom-0 w-100 p-6 text-center transition-all duration-500 hover:mb-12">
                                <h4 class="mb-1 text-lg lg:text-xl font-black uppercase italic tracking-tighter">{{ $service->name }}</h4>
                                <p class="text-[10px] lg:text-xs text-[#28a745] font-black uppercase tracking-widest">{{ __('front.from') }} €{{ number_format($service->base_price, 0) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <section id="configurator" class="py-12 lg:py-24">
        <div class="container">
            <div class="row justify-content-center mb-8 lg:mb-12">
                <div class="col-lg-8 text-center px-4">
                    <div class="subtitle text-[10px] lg:text-xs">{{ __('front.personalize') }}</div>
                    <h2 class="text-3xl lg:text-5xl">{{ __('front.configure_your_service') }}</h2>
                    <p class="text-gray-400 text-sm lg:text-base">{{ __('front.steps_description') }}</p>
                </div>
            </div>

            @if($success)
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center py-12 bg-dark-2 rounded-2xl mx-4">
                        <i class="fa fa-check id-color fa-3x mb-4"></i>
                        <h3 class="text-2xl font-bold text-white mb-2">{{ __('front.request_sent') }}</h3>
                        <p class="text-gray-400">{{ __('front.contact_soon') }}</p>
                        <button wire:click="$set('success', false)" class="mt-6 btn-main btn-line"><span>{{ __('front.configure_another') }}</span></button>
                    </div>
                </div>
            @else
                {{-- STEP 1 & 2: VEHICLE TYPE & CONFIGURATION --}}
                @if($step == 1 || $step == 2)
                <div class="animate-fadeIn space-y-12">
                    {{-- Category Selection (Always Visible in Configurator) --}}
                    <div>
                        <h5 class="text-white text-[10px] font-black uppercase tracking-[0.2em] mb-6 opacity-50 flex items-center gap-2">
                            <span class="w-8 h-[1px] bg-white/20"></span>
                            {{ __('front.step_1_title') }}
                        </h5>

                        {{-- Clean Horizontal Scroll for Mobile --}}
                        <div class="flex overflow-x-auto gap-4 pb-4 no-scrollbar -mx-4 px-4 lg:mx-0 lg:px-0 lg:grid lg:grid-cols-6 lg:flex-wrap">
                            <style>
                                .no-scrollbar::-webkit-scrollbar { display: none; }
                                .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
                            </style>
                            @foreach($bodyTypes as $bt)
                            <div wire:click="selectBodyType({{ $bt->id }})"
                                 class="flex-shrink-0 cursor-pointer group w-24 lg:w-auto">
                                <div class="aspect-square rounded-[2rem] border-2 flex items-center justify-center transition-all duration-500 {{ $body_type_id == $bt->id ? 'border-[#28a745] bg-[#28a745]/10 shadow-[0_0_20px_rgba(40,167,69,0.2)] scale-105' : 'border-white/5 bg-white/2 hover:border-white/10' }}">
                                    <img src="{{ asset($bt->image) }}" alt="{{ $bt->name }}"
                                         class="w-3/4 h-auto object-contain transition-all duration-500 {{ $body_type_id == $bt->id ? '' : 'grayscale opacity-40 group-hover:grayscale-0 group-hover:opacity-100' }}">
                                </div>
                                <span class="block text-center text-[9px] font-black uppercase mt-3 tracking-tighter transition-colors {{ $body_type_id == $bt->id ? 'text-[#28a745]' : 'text-gray-500' }}">
                                    {{ $bt->name }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    @if($step == 2)
                    <div class="row g-4 lg:g-5">
                        <div class="col-12 text-center mb-4">
                            <h2 class="text-2xl lg:text-4xl text-white">{{ __('front.fill_basket') }}</h2>
                            <p class="text-gray-400 text-sm">{{ __('front.basket_description') }}</p>
                        </div>

                        <div class="col-lg-7">
                            <h5 class="text-white text-[10px] font-black uppercase tracking-[0.2em] mb-6 opacity-50 flex items-center gap-2">
                                <span class="w-8 h-[1px] bg-white/20"></span>
                                {{ __('front.detailing_services') }}
                            </h5>
                            <div class="row g-3">
                                @foreach($services as $s)
                                <div class="col-md-6 col-12">
                                    <div wire:click="toggleService({{ $s->id }})"
                                         class="wizard-card flex-row justify-content-between p-4 min-h-[80px] {{ in_array($s->id, $selected_services) ? 'active' : '' }}">
                                        <div class="text-start">
                                            <h4 class="mb-0 text-white text-xs lg:text-sm">{{ $s->name }}</h4>
                                            <span class="text-[#28a745] font-black text-xs">€{{ number_format($s->base_price, 0) }}</span>
                                        </div>
                                        @if(in_array($s->id, $selected_services))
                                            <i class="fa fa-check-circle text-xl text-[#28a745]"></i>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <h5 class="text-white text-[10px] font-black uppercase tracking-[0.2em] mb-6 opacity-50 flex items-center gap-2">
                                <span class="w-8 h-[1px] bg-white/20"></span>
                                {{ __('front.choose_wrap') }}
                            </h5>
                            <div class="row g-2">
                                @foreach($materials as $mat)
                                <div class="col-6">
                                    <div wire:click="selectMaterial({{ $mat->id }})"
                                         class="wizard-card p-4 text-center {{ $material_id == $mat->id ? 'active' : '' }}">
                                        <h4 class="text-[10px] mb-1">{{ $mat->name }}</h4>
                                        <span class="text-[#28a745] font-black text-[10px]">+€{{ number_format($mat->sell_price, 0) }}/m</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 mt-12">
                            <div class="price-estimate-container border border-white/5 rounded-2xl p-6 lg:p-10 bg-dark-2">
                                <div class="text-center lg:text-left mb-6 lg:mb-0">
                                    <span class="text-[10px] text-gray-500 uppercase tracking-widest block mb-1">{{ __('front.estimated_total') }}</span>
                                    <div class="text-4xl lg:text-6xl font-black text-white italic">€{{ number_format($this->estimatedPrice, 0) }}</div>
                                </div>
                                <button wire:click="goToStep(3)"
                                        class="btn-main fx-slide w-full lg:w-auto px-12 py-4 {{ empty($selected_services) && !$material_id ? 'opacity-50 pointer-events-none' : '' }}">
                                    <span>{{ __('front.continue_to_contact') }} <i class="fa fa-arrow-right ms-2"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- STEP 3: CONTACT --}}
                @if($step == 3)
                <div class="row justify-content-center animate-fadeIn">
                    <div class="col-lg-8">
                        <div class="p-40 bg-dark-2 rounded-1">
                            <button wire:click="goToStep(2)" class="btn-back mb-4"><i class="fa fa-arrow-left"></i> {{ __('front.change_services') }}</button>
                            <h2 class="mb-4">{{ __('front.your_data') }}</h2>
                            <form wire:submit.prevent="submitAppointment" class="form-border">
                                <div class="row g-3">
                                    <div class="col-md-6"><input type="text" wire:model="brand" class="form-control" placeholder="{{ __('front.brand_placeholder') }}" required></div>
                                    <div class="col-md-6"><input type="text" wire:model="model" class="form-control" placeholder="{{ __('front.model_placeholder') }}" required></div>
                                    <div class="col-md-12"><input type="text" wire:model="name" class="form-control" placeholder="{{ __('front.name_placeholder') }}" required></div>
                                    <div class="col-md-12"><input type="text" wire:model="phone" class="form-control" placeholder="{{ __('front.phone_placeholder') }}" required></div>
                                    <div class="col-md-12"><input type="email" wire:model="email" class="form-control" placeholder="{{ __('front.email_placeholder') }}"></div>
                                    <div class="col-md-12"><textarea wire:model="message" class="form-control" placeholder="{{ __('front.notes_placeholder') }}" rows="3"></textarea></div>
                                    <div class="col-md-12 mt-4"><button type="submit" class="btn-main fx-slide w-100 py-3"><span>{{ __('front.send_request') }} <i class="fa fa-paper-plane ms-2"></i></span></button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </section>

    <script>
        document.addEventListener('livewire:init', () => {
           Livewire.on('scroll-to-configurator', () => {
               const element = document.getElementById('configurator');
               if (element) {
                   element.scrollIntoView({ behavior: 'smooth', block: 'start' });
               }
           });
        });
    </script>


</div>
