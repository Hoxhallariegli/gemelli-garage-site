@section('title', __('Login'))

<x-layouts.guest>
    <section class="jarallax">
        <img src="{{ asset('assets/front/gemelli-garage/images/background/4.webp') }}" class="jarallax-img" alt="">
        <div class="sw-overlay"></div>
        <div class="container relative z-3">
            <div class="spacer-double"></div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-5">
                    <div class="p-40 bg-dark-2 rounded-1 relative overflow-hidden text-light shadow-2xl">
                        <div class="text-center mb-4">
                            <h3 class="text-2xl font-bold text-white uppercase tracking-tight">Admin Login</h3>
                            <p class="text-gray-400">Inserisci le tue credenziali per accedere.</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="form-border">
                            @csrf



                            <div class="mb-4">
                                <label class="text-white text-xs font-bold uppercase tracking-widest mb-2 block">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required autofocus>
                                @error('email')
                                    <span class="red text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="text-white text-xs font-bold uppercase tracking-widest mb-2 block">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                @error('password')
                                    <span class="red text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mb-4">
                                <a href="{{ route('password.request') }}" class="text-gray-400 text-xs hover:text-white transition">Dimenticato la password?</a>
                            </div>

                            <button type="submit" class="btn-main w-100 py-3">Login</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="spacer-double"></div>
        </div>
    </section>
</x-layouts.guest>
