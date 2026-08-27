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
                        <h1 class="fs-72 fs-xs-10vw text-uppercase wow fadeInUp">Where Every Detail Truly Matters</h1>
                        <p class="mb-0 col-lg-6 offset-lg-3 wow fadeInUp" data-wow-delay=".2s">Gemelli Garage offers efficient, reliable detailing that restores shine and preserves your vehicle.</p>
                        <div class="spacer-single"></div>
                        <a class="btn-main fx-slide" href="#configurator"><span>Configura Ora</span></a>
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
                            <div class="subtitle">I Nostri Servizi</div>
                            <h2>Premium Detailing & Wrapping</h2>
                            <p>Scegli tra i nostri trattamenti professionali per esaltare la bellezza della tua auto.</p>
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
                            <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                <button type="button" class="btn-main fx-slide" wire:click="toggleService({{ $service->id }}); goToStep(2);"><span>Aggiungi al Preventivo</span></button>
                            </div>
                            <h3 class="abs fs-32 lh-1 p-4 top-0 start-0 z-2">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</h3>
                            <div class="abs bg-blur z-2 top-0 w-100 h-100 hover-op-1"></div>
                            <div class="sw-overlay op-8"></div>
                            <div class="abs z-2 abs-middle mt-2 w-100 text-center hover-op-0">
                                <h4 class="mb-1">{{ $service->name }}</h4>
                                <p class="text-xs text-gray-300">Da €{{ number_format($service->base_price, 0) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <section id="configurator" class="pb-100">
        <div class="container">
            <div class="row g-4 justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <div class="subtitle">Personalizza</div>
                    <h2>Configura il tuo Servizio</h2>
                    <p class="text-gray-400">Pochi semplici passi per scoprire il costo e prenotare il trattamento ideale per la tua auto.</p>
                </div>
            </div>

            @if($success)
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center py-10 bg-dark-2 rounded-1">
                        <i class="fa fa-check id-color fa-3x mb-4"></i>
                        <h3 class="text-2xl font-bold text-white mb-2">Richiesta Inviata!</h3>
                        <p class="text-gray-400">Ti contatteremo a breve per confermare tutti i dettagli.</p>
                        <button wire:click="$set('success', false)" class="mt-6 btn-main btn-line"><span>Configura un'altra auto</span></button>
                    </div>
                </div>
            @else
                {{-- STEP 1: VEHICLE TYPE --}}
                @if($step == 1)
                <div class="row g-4 animate-fadeIn">
                    <div class="col-12 text-center mb-5">
                        <h4 class="text-white text-uppercase tracking-widest fs-14">Hapi 1: Zgjidh Kategorinë e Mjetit</h4>
                    </div>
                    @foreach($bodyTypes as $bt)
                    <div class="col-lg-2 col-md-3 col-6">
                        <div wire:click="selectBodyType({{ $bt->id }})" class="wizard-card {{ $body_type_id == $bt->id ? 'active' : '' }}">
                            <img src="{{ asset($bt->image) }}" alt="{{ $bt->name }}">
                            <h4>{{ $bt->name }}</h4>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- STEP 2: SERVICES & MATERIALS (BASKET) --}}
                @if($step == 2)
                <div class="row g-5 animate-fadeIn">
                    <div class="col-12 text-center mb-4">
                        <button wire:click="goToStep(1)" class="btn-back mb-3"><i class="fa fa-arrow-left"></i> Kthehu te Mjeti ({{ $bodyTypes->find($body_type_id)->name }})</button>
                        <h2>Mbush Shportën</h2>
                        <p class="text-gray-400">Zgjidh shërbimet dhe letrën që dëshiron. Çmimi llogaritet në kohë reale.</p>
                    </div>

                    <div class="col-lg-7">
                        <h5 class="text-white text-uppercase tracking-widest fs-12 mb-4 border-l-2 border-[#28a745] pl-3">1. Shërbimet Detailing</h5>
                        <div class="row g-3">
                            @foreach($services as $s)
                            <div class="col-md-6">
                                <div wire:click="toggleService({{ $s->id }})" class="wizard-card flex-row justify-content-between p-3 {{ in_array($s->id, $selected_services) ? 'active' : '' }}">
                                    <div class="text-start">
                                        <h4 class="mb-0 text-white fs-12">{{ $s->name }}</h4>
                                        <span class="text-[#28a745] font-bold fs-11">€{{ number_format($s->base_price, 0) }}</span>
                                    </div>
                                    @if(in_array($s->id, $selected_services)) <i class="fa fa-check-circle text-[#28a745]"></i> @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <h5 class="text-white text-uppercase tracking-widest fs-12 mb-4 border-l-2 border-[#28a745] pl-3">2. Zgjidh Letrën (Wrapping)</h5>
                        <div class="row g-2">
                            @foreach($materials as $mat)
                            <div class="col-6">
                                <div wire:click="selectMaterial({{ $mat->id }})" class="wizard-card p-3 {{ $material_id == $mat->id ? 'active' : '' }}">
                                    <h4 class="fs-10 mb-1">{{ $mat->name }}</h4>
                                    <span class="text-[#28a745] font-black fs-10">+€{{ number_format($mat->sell_price, 0) }}/m</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 mt-10">
                        <div class="price-estimate-container border border-white/5 rounded-1">
                            <div>
                                <span class="text-[10px] text-gray-500 uppercase tracking-widest">Totale Stimato</span>
                                <div class="text-4xl font-black text-white">€{{ number_format($this->estimatedPrice, 0) }}</div>
                            </div>
                            <button wire:click="goToStep(3)" class="btn-main fx-slide px-10 py-3 {{ empty($selected_services) && !$material_id ? 'opacity-50 pointer-events-none' : '' }}"><span>Vazhdo te Kontaktet <i class="fa fa-arrow-right ms-2"></i></span></button>
                        </div>
                    </div>
                </div>
                @endif

                {{-- STEP 3: CONTACT --}}
                @if($step == 3)
                <div class="row justify-content-center animate-fadeIn">
                    <div class="col-lg-8">
                        <div class="p-40 bg-dark-2 rounded-1">
                            <button wire:click="goToStep(2)" class="btn-back mb-4"><i class="fa fa-arrow-left"></i> Ndrysho Shërbimet</button>
                            <h2 class="mb-4">Të dhënat tuaja</h2>
                            <form wire:submit.prevent="submitAppointment" class="form-border">
                                <div class="row g-3">
                                    <div class="col-md-6"><input type="text" wire:model="brand" class="form-control" placeholder="Marca (es. BMW)" required></div>
                                    <div class="col-md-6"><input type="text" wire:model="model" class="form-control" placeholder="Modello (es. X5)" required></div>
                                    <div class="col-md-12"><input type="text" wire:model="name" class="form-control" placeholder="Nome Completo" required></div>
                                    <div class="col-md-12"><input type="text" wire:model="phone" class="form-control" placeholder="Telefono" required></div>
                                    <div class="col-md-12"><input type="email" wire:model="email" class="form-control" placeholder="Email"></div>
                                    <div class="col-md-12"><textarea wire:model="message" class="form-control" placeholder="Note" rows="3"></textarea></div>
                                    <div class="col-md-12 mt-4"><button type="submit" class="btn-main fx-slide w-100 py-3"><span>Dërgo Kërkesën <i class="fa fa-paper-plane ms-2"></i></span></button></div>
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
           Livewire.on('scroll-to-contact', (event) => {
               const element = document.getElementById('configurator');
               if (element) {
                   element.scrollIntoView({ behavior: 'smooth', block: 'start' });
               }
           });
        });
    </script>


</div>
