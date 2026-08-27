@section('title', __('Verify Email'))

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
                            <h3 class="text-2xl font-bold text-white uppercase tracking-tight">Verify Email</h3>
                            <p class="text-gray-400">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>
                        </div>

                        @if (session('status') === 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif

                        <div class="d-flex flex-column gap-3">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn-main w-100 py-3">{{ __('Resend Verification Email') }}</button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn-main btn-line w-100 py-3"><span>{{ __('Log Out') }}</span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="spacer-double"></div>
        </div>
    </section>
</x-layouts.guest>
