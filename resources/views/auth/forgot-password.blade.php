@section('title', __('Forgot Password'))

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
                            <h3 class="text-2xl font-bold text-white uppercase tracking-tight">Forgot Password</h3>
                            <p class="text-gray-400">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
                        </div>

                        <form method="POST" action="{{ route('password.email') }}" class="form-border">
                            @csrf



                            <div class="mb-4">
                                <label class="text-white text-xs font-bold uppercase tracking-widest mb-2 block">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required autofocus>
                                @error('email')
                                    <span class="red text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn-main w-100 py-3">{{ __('Email Password Reset Link') }}</button>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-gray-400 text-xs hover:text-white transition">Back to Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="spacer-double"></div>
        </div>
    </section>
</x-layouts.guest>
