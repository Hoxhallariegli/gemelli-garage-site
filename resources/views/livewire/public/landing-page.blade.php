<div>
    <style>
        /* GEMELLI PREMIUM SYNC - NO TAILWIND TRASH */

        /* 1. Reset & Sync Input Styles */
        #contact .relative input[type="text"],
        #contact .form-control,
        #configurator .form-control {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(40, 167, 69, 0.3) !important;
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
            transition: all 0.5s ease;
        }

        .wizard-card.active img {
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

        /* Mobile Adjustments for Wizard Cards */
        @media (max-width: 768px) {
            .jarallax { min-height: 70vh !important; }
            .wizard-card {
                padding: 10px;
            }
            .wizard-card img {
                max-width: 80px;
                margin-bottom: 5px;
            }
            .wizard-card h4 {
                font-size: 9px;
                letter-spacing: 1px;
            }
            .price-estimate-container {
                display: none !important; /* Hidden on mobile, using sticky footer instead */
            }
            .section-padding-mobile {
                padding-top: 40px !important;
                padding-bottom: 40px !important;
            }
        }

        /* Sticky Footer for Mobile */
        .sticky-action-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #111;
            border-top: 1px solid rgba(40, 167, 69, 0.3);
            padding: 15px 20px;
            z-index: 9999;
            display: none;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.5);
        }

        @media (max-width: 768px) {
            .sticky-action-bar {
                display: flex;
            }
            body {
                padding-bottom: 80px; /* Space for sticky bar */
            }
        }

        /* Step Progress Indicator */
        .step-progress-wrapper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }
        .step-progress-wrapper::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 2px;
            background: rgba(255,255,255,0.05);
            z-index: 1;
        }
        .step-progress-bar {
            position: absolute;
            top: 50%;
            left: 0;
            height: 2px;
            background: #28a745;
            z-index: 2;
            transition: width 0.5s ease;
        }
        .step-item {
            position: relative;
            z-index: 3;
            width: 30px;
            height: 30px;
            background: #1a1a1a;
            border: 2px solid rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            color: #666;
            transition: all 0.3s ease;
        }
        .step-item.active {
            border-color: #28a745;
            color: #fff;
            background: #28a745;
            box-shadow: 0 0 15px rgba(40, 167, 69, 0.5);
        }
        .step-item.completed {
            border-color: #28a745;
            color: #28a745;
            background: #1a1a1a;
        }

        /* Summary Widget Styles */
        .selection-summary-container {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .summary-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding-bottom: 8px;
        }
        .summary-items {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
        }
        .summary-tag {
            display: inline-flex;
            align-items: center;
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            white-space: nowrap;
        }
        .summary-tag.warning {
            background: rgba(255, 0, 0, 0.1);
            border-color: rgba(255, 0, 0, 0.3);
            color: #ff4444;
        }
        .summary-tag i.fa-times {
            margin-left: 8px;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.3s;
        }
        .summary-tag i.fa-times:hover {
            opacity: 1;
        }
        .summary-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #666;
            white-space: nowrap;
        }
        .btn-change-vehicle {
            font-size: 9px;
            color: #28a745;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 700;
        }
        .btn-change-vehicle:hover {
            text-decoration: underline;
            opacity: 0.8;
        }
        /* Service Card Fix - No Hover Reveal */
        .hover .abs-centered {
            opacity: 1 !important;
            pointer-events: auto !important;
            transform: translate(-50%, -50%) !important;
            top: 50% !important;
            left: 50% !important;
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }
        .hover .hover-op-0 {
            opacity: 1 !important;
        }
        .hover .bg-blur {
            display: none !important;
        }
        .sw-overlay.op-8 {
            opacity: 0.3 !important; /* Lighter overlay to see colors */
        }
        .hover-scale-1-1:hover {
            transform: none !important;
        }
        .abs-middle {
            top: 80% !important; /* Move title down to not overlap button */
        }

        /* FAQ Override */
        .accordion-section-content.show-active {
            display: block !important;
        }

        /* Brand Slider Fix */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .brand-card-wrapper {
            flex: 0 0 auto;
        }
        .brand-card-wrapper .wizard-card img {
            filter: none !important;
            opacity: 1 !important;
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

        <section class="pt-0" id="services">
            <div class="container">
                <div class="row g-4 justify-content-center mb-2">
                    <div class="col-lg-6">
                        <div class="text-center">
                            <div class="subtitle">{{ __('front.our_services') }}</div>
                            <h2>{{ __('front.premium_detailing') }}</h2>
                            <p>{{ __('front.choose_treatment') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($services as $index => $service)
                    <div class="col-sm-6 col-md-4" wire:key="service-card-{{ $service->id }}">
                        <div class="hover rounded-1 overflow-hidden relative text-light text-center wow fadeInRight" data-wow-delay=".{{ $index * 2 }}s">
                            @if($service->image)
                                <img src="{{ asset($service->image) }}" class="hover-scale-1-1 w-100 object-cover h-64" alt="{{ $service->name }}">
                            @else
                                <img src="{{ asset('assets/front/gemelli-garage/images/services-2/'.(($index % 4) + 1).'.webp') }}" class="hover-scale-1-1 w-100 h-64 object-cover" alt="">
                            @endif
                            <div class="abs w-100 px-4 z-4 abs-centered">
                                <button type="button" class="btn-main fx-slide"
                                    wire:click="addServiceAndScroll({{ $service->id }})">
                                    <span>{{ __('front.add_to_quote') }}</span>
                                </button>
                            </div>
                            <h3 class="abs fs-32 lh-1 p-4 top-0 start-0 z-2">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</h3>
                            <div class="sw-overlay op-8"></div>
                            <div class="abs z-2 abs-middle mt-2 w-100 text-center">
                                <h4 class="mb-1">{{ $service->name }}</h4>
                                <p class="text-xs text-gray-300">{{ __('front.from') }} €{{ number_format($service->base_price, 0) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- BENEFITS SECTION --}}
        <section class="no-top pb-20">
            <div class="container">
                <div class="row g-4 text-center">
                    <div class="col-lg-12">
                        <div class="subtitle">{{ __('front.personalize') }}</div>
                        <h2 class="fs-32">{{ __('front.why_wrap_title') }}</h2>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box f-boxed style-3">
                            <i class="bg-color i-circle fa fa-shield-halved"></i>
                            <div class="text">
                                <h4>{{ __('front.benefit_1_title') }}</h4>
                                {{ __('front.benefit_1_desc') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box f-boxed style-3">
                            <i class="bg-color i-circle fa fa-palette"></i>
                            <div class="text">
                                <h4>{{ __('front.benefit_2_title') }}</h4>
                                {{ __('front.benefit_2_desc') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-box f-boxed style-3">
                            <i class="bg-color i-circle fa fa-clock-rotate-left"></i>
                            <div class="text">
                                <h4>{{ __('front.benefit_3_title') }}</h4>
                                {{ __('front.benefit_3_desc') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- BRANDS SECTION --}}
    @if($materialBrands->count() > 0)
    <section class="no-top pb-20">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12">
                    <span class="text-xs uppercase tracking-widest text-gray-500 mb-4 d-block">{{ __('front.brands_title') }}</span>

                    {{-- Desktop Grid --}}
                    <div class="row g-3 justify-content-center d-none d-md-flex">
                        @foreach($materialBrands as $brand)
                        <div class="col-lg-2 col-md-3">
                            <div class="wizard-card" style="padding: 15px; height: 100px; transform: none !important; cursor: default; background: rgba(255,255,255,0.02) !important;">
                                @if($brand->image)
                                    <img src="{{ asset($brand->image) }}" class="img-fluid mb-2" alt="{{ $brand->name }}" style="max-height: 40px; object-fit: contain; filter: none !important; opacity: 1 !important;">
                                @endif
                                <h4 class="mb-0 text-white fs-10 tracking-wider uppercase" style="color: #fff !important;">{{ $brand->name }}</h4>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Mobile Slider --}}
                    <div class="d-flex d-md-none overflow-x-auto no-scrollbar gap-2 pb-2">
                        @foreach($materialBrands as $brand)
                        <div class="brand-card-wrapper" style="min-width: 140px; flex: 0 0 auto;">
                            <div class="wizard-card" style="padding: 10px; height: 90px; transform: none !important; cursor: default; background: rgba(255,255,255,0.02) !important;">
                                @if($brand->image)
                                    <img src="{{ asset($brand->image) }}" class="img-fluid mb-2" alt="{{ $brand->name }}" style="max-height: 35px; object-fit: contain; filter: none !important; opacity: 1 !important;">
                                @endif
                                <h4 class="mb-0 text-white fs-9 tracking-wider uppercase" style="color: #fff !important;">{{ $brand->name }}</h4>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section id="configurator" class="pb-100">
        <div class="container">
            {{-- Progress Indicator --}}
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6">
                    <div class="step-progress-wrapper">
                        <div class="step-progress-bar" style="width: {{ ($step - 1) * 50 }}%"></div>
                        <div class="step-item {{ $step >= 1 ? 'active' : '' }} {{ $step > 1 ? 'completed' : '' }}">1</div>
                        <div class="step-item {{ $step >= 2 ? 'active' : '' }} {{ $step > 2 ? 'completed' : '' }}">2</div>
                        <div class="step-item {{ $step >= 3 ? 'active' : '' }}">3</div>
                    </div>
                    <div class="text-center">
                        @if($step == 1) <span class="text-xs uppercase tracking-widest text-gray-500">{{ __('front.step_1_label') ?? 'Kategoria e Mjetit' }}</span> @endif
                        @if($step == 2) <span class="text-xs uppercase tracking-widest text-gray-500">{{ __('front.step_2_label') ?? 'Zgjidh Shërbimet' }}</span> @endif
                        @if($step == 3) <span class="text-xs uppercase tracking-widest text-gray-500">{{ __('front.step_3_label') ?? 'Të Dhënat Tuaja' }}</span> @endif
                    </div>
                </div>
            </div>

            @if($success)
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center py-10 bg-dark-2 rounded-1">
                        <i class="fa fa-check id-color fa-3x mb-4"></i>
                        <h3 class="text-2xl font-bold text-white mb-2">{{ __('front.request_sent') }}</h3>
                        <p class="text-gray-400">{{ __('front.contact_soon') }}</p>
                        <button wire:click="$set('success', false)" class="mt-6 btn-main btn-line"><span>{{ __('front.configure_another') }}</span></button>
                    </div>
                </div>
            @else
                <div x-data="{ showNotify: false, message: '', type: '' }"
                     x-on:notify.window="showNotify = true; message = $event.detail[0].message; type = $event.detail[0].type; setTimeout(() => showNotify = false, 3000)"
                     x-show="showNotify"
                     x-transition
                     class="fixed top-20 right-5 z-[9999] px-4 py-2 rounded shadow-lg text-white"
                     :class="type === 'error' ? 'bg-red-600' : 'bg-green-600'"
                     style="display: none;">
                    <span x-text="message"></span>
                </div>

                {{-- SELECTION SUMMARY WIDGET (Visible in Step 2 & 3) --}}
                @if($step > 1)
                <div class="row justify-content-center animate-fadeIn">
                    <div class="col-lg-12">
                        <div class="selection-summary-container">
                            <div class="summary-header">
                                <span class="summary-label"><i class="fa fa-shopping-basket me-2"></i> {{ __('front.your_selection') ?? 'Zgjedhja Juaj' }}</span>
                                @if($step == 2)
                                    <a wire:click="goToStep(1)" class="btn-change-vehicle"><i class="fa fa-sync-alt me-1"></i> {{ __('front.change_vehicle_short') ?? 'Ndrysho' }}</a>
                                @endif
                            </div>

                            <div class="summary-items">
                                @if($this->selectedBodyTypeData)
                                    <div class="summary-tag">
                                        <i class="fa fa-car me-2"></i> {{ $this->selectedBodyTypeData->name }}
                                        <i class="fa fa-times" wire:click="goToStep(1)"></i>
                                    </div>
                                @else
                                    <div class="summary-tag warning" wire:click="goToStep(1)" style="cursor:pointer;">
                                        <i class="fa fa-exclamation-triangle me-2"></i> {{ __('front.vehicle_required') ?? 'Mjeti i Detyrueshëm' }}
                                    </div>
                                @endif

                                @foreach($this->selectedServicesData as $s)
                                    <div class="summary-tag">
                                        {{ $s->name }}
                                        <i class="fa fa-times" wire:click="toggleService({{ $s->id }})"></i>
                                    </div>
                                @endforeach

                                @if($this->selectedMaterialData)
                                    <div class="summary-tag">
                                        <i class="fa fa-fill-drip me-2"></i> {{ $this->selectedMaterialData->name }}
                                        <i class="fa fa-times" wire:click="selectMaterial({{ $this->selectedMaterialData->id }})"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                {{-- STEP 1: VEHICLE TYPE --}}
                @if($step == 1)
                {{-- Desktop Grid --}}
                <div class="row g-3 animate-fadeIn justify-content-center d-none d-md-flex">
                    <div class="col-12 text-center mb-3">
                        <div class="subtitle">{{ __('front.personalize') }}</div>
                        <h2 class="fs-32">{{ __('front.step_1_title') }}</h2>
                    </div>
                    @foreach($bodyTypes as $bt)
                    <div class="col-lg-2 col-md-3">
                        <div wire:click="selectBodyType({{ $bt->id }})" class="wizard-card {{ $body_type_id == $bt->id ? 'active' : '' }}" style="padding: 10px;">
                            <img src="{{ asset($bt->image) }}" alt="{{ $bt->name }}" class="img-fluid" style="max-width: 100px;">
                            <h4 class="fs-10">{{ $bt->name }}</h4>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Mobile Slider --}}
                <div class="d-md-none animate-fadeIn">
                    <div class="text-center mb-3">
                        <div class="subtitle">{{ __('front.personalize') }}</div>
                        <h2 class="fs-24">{{ __('front.step_1_title') }}</h2>
                    </div>
                    <div class="d-flex overflow-x-auto no-scrollbar gap-2 pb-2">
                        @foreach($bodyTypes as $bt)
                        <div style="min-width: 120px; flex: 0 0 auto;">
                            <div wire:click="selectBodyType({{ $bt->id }})" class="wizard-card {{ $body_type_id == $bt->id ? 'active' : '' }}" style="padding: 10px;">
                                <img src="{{ asset($bt->image) }}" alt="{{ $bt->name }}" class="img-fluid" style="max-width: 80px;">
                                <h4 class="fs-9">{{ $bt->name }}</h4>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- STEP 2: SERVICES & MATERIALS --}}
                @if($step == 2)
                <div class="row g-4 animate-fadeIn mt-0">
                    <div class="{{ $this->isWrapSelected ? 'col-lg-7' : 'col-lg-12' }}">
                        <h5 class="text-white text-uppercase tracking-widest fs-10 mb-3 border-l-2 border-[#28a745] pl-3">{{ __('front.detailing_services') }}</h5>
                        <div class="row g-2">
                            @foreach($services as $s)
                            <div class="{{ $this->isWrapSelected ? 'col-md-6' : 'col-md-4' }}">
                                <div wire:click="toggleService({{ $s->id }})" class="wizard-card flex-row justify-content-between p-2 {{ in_array($s->id, $selected_services) ? 'active' : '' }}" style="min-height: 50px;">
                                    <div class="text-start">
                                        <h4 class="mb-0 text-white fs-11">{{ $s->name }}</h4>
                                        <span class="text-[#28a745] font-bold fs-10">€{{ number_format($s->base_price, 0) }}</span>
                                    </div>
                                    @if(in_array($s->id, $selected_services)) <i class="fa fa-check-circle text-[#28a745] fs-12"></i> @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    @if($this->isWrapSelected)
                    <div class="col-lg-5 animate-fadeIn">
                        <h5 class="text-white text-uppercase tracking-widest fs-10 mb-3 border-l-2 border-[#28a745] pl-3">{{ __('front.choose_wrap') }}</h5>
                        <div class="row g-2">
                            @foreach($materials as $mat)
                            <div class="col-6">
                                <div wire:click="selectMaterial({{ $mat->id }})" class="wizard-card p-2 {{ $material_id == $mat->id ? 'active' : '' }}" style="min-height: 50px;">
                                    <h4 class="fs-10 mb-0">{{ $mat->name }}</h4>
                                    <span class="text-[#28a745] font-black fs-9">+€{{ number_format($mat->sell_price, 0) }}/m</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="col-12 mt-4">
                        <div class="price-estimate-container border border-white/5 rounded-1 p-3 m-0">
                            <div>
                                <span class="text-[9px] text-gray-500 uppercase tracking-widest">{{ __('front.estimated_total') }}</span>
                                <div class="text-3xl font-black text-white">€{{ number_format($this->estimatedPrice, 0) }}</div>
                            </div>
                            <button wire:click="goToStep(3)" class="btn-main fx-slide px-8 py-2 {{ (empty($selected_services) && !$material_id) || !$body_type_id ? 'opacity-50 pointer-events-none' : '' }}"><span>{{ __('front.continue_to_contact') }} <i class="fa fa-arrow-right ms-2"></i></span></button>
                        </div>
                    </div>
                </div>
                @endif

                {{-- STEP 3: CONTACT --}}
                @if($step == 3)
                <div class="row justify-content-center animate-fadeIn mt-2">
                    <div class="col-lg-10">
                        <div class="p-30 bg-dark-2 rounded-1 section-padding-mobile" style="padding: 25px !important;">
                            <h2 class="mb-3 fs-24">{{ __('front.your_data') }}</h2>
                            <form wire:submit.prevent="submitAppointment" class="form-border">
                                <div class="row g-2">
                                    <div class="col-md-6"><input type="text" wire:model="brand" class="form-control" placeholder="{{ __('front.brand_placeholder') }}" required style="height: 40px !important;"></div>
                                    <div class="col-md-6"><input type="text" wire:model="model" class="form-control" placeholder="{{ __('front.model_placeholder') }}" required style="height: 40px !important;"></div>
                                    <div class="col-md-6"><input type="text" wire:model="name" class="form-control" placeholder="{{ __('front.name_placeholder') }}" required style="height: 40px !important;"></div>
                                    <div class="col-md-6"><input type="text" wire:model="phone" class="form-control" placeholder="{{ __('front.phone_placeholder') }}" required inputmode="tel" style="height: 40px !important;"></div>
                                    <div class="col-md-12"><input type="email" wire:model="email" class="form-control" placeholder="{{ __('front.email_placeholder') }}" style="height: 40px !important;"></div>
                                    <div class="col-md-12"><textarea wire:model="message" class="form-control" placeholder="{{ __('front.notes_placeholder') }}" rows="2"></textarea></div>
                                    <div class="col-md-12 mt-3"><button type="submit" class="btn-main fx-slide w-100 py-2"><span>{{ __('front.send_request') }} <i class="fa fa-paper-plane ms-2"></i></span></button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>

        {{-- STICKY FOOTER (MOBILE ONLY) --}}
        @if(!$success && $step == 2)
        <div class="sticky-action-bar animate-fadeInUp">
            <div class="text-start">
                <span class="text-[9px] text-gray-500 uppercase tracking-widest block">{{ __('front.total') ?? 'Totali' }}</span>
                <span class="text-xl font-black text-white">€{{ number_format($this->estimatedPrice, 0) }}</span>
            </div>
            <button wire:click="goToStep(3)" class="btn-main fx-slide {{ (empty($selected_services) && !$material_id) || !$body_type_id ? 'opacity-50 pointer-events-none' : '' }}" style="padding: 10px 20px;">
                <span>{{ __('front.continue') ?? 'Vazhdo' }} <i class="fa fa-arrow-right ms-2"></i></span>
            </button>
        </div>
        @endif
    </section>

    {{-- FAQ SECTION --}}
    <section class="no-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="subtitle">{{ __('front.personalize') }}</div>
                    <h2>{{ __('front.faq_title') }}</h2>
                    <div class="spacer-single"></div>

                    <div class="accordion s2" x-data="{ active: 1 }">
                        <div class="accordion-section">
                            <div class="accordion-section-title" :class="{ 'active': active === 1 }" @click.stop="active = (active === 1 ? null : 1)">
                                {{ __('front.faq_1_q') }}
                            </div>
                            <div class="accordion-section-content" :class="{ 'show-active': active === 1 }">
                                <p>{{ __('front.faq_1_a') }}</p>
                            </div>
                        </div>

                        <div class="accordion-section">
                            <div class="accordion-section-title" :class="{ 'active': active === 2 }" @click.stop="active = (active === 2 ? null : 2)">
                                {{ __('front.faq_2_q') }}
                            </div>
                            <div class="accordion-section-content" :class="{ 'show-active': active === 2 }">
                                <p>{{ __('front.faq_2_a') }}</p>
                            </div>
                        </div>

                        <div class="accordion-section">
                            <div class="accordion-section-title" :class="{ 'active': active === 3 }" @click.stop="active = (active === 3 ? null : 3)">
                                {{ __('front.faq_3_q') }}
                            </div>
                            <div class="accordion-section-content" :class="{ 'show-active': active === 3 }">
                                <p>{{ __('front.faq_3_a') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('livewire:init', () => {
           Livewire.on('scroll-to-configurator', () => {
               const element = document.getElementById('configurator');
               if (element) {
                   const offset = 80; // Offset for potential sticky header
                   const bodyRect = document.body.getBoundingClientRect().top;
                   const elementRect = element.getBoundingClientRect().top;
                   const elementPosition = elementRect - bodyRect;
                   const offsetPosition = elementPosition - offset;

                   window.scrollTo({
                       top: offsetPosition,
                       behavior: 'smooth'
                   });
               }
           });
        });
    </script>


</div>
