@section('title', __('Join'))

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
                            <h3 class="text-2xl font-bold text-white uppercase tracking-tight">{{ __('Complete Invitation') }}</h3>
                            <p class="text-gray-400">{{ $user->invite->name ?? 'Admin' }} {{ __('has invited you to join') }} {{ config('app.name') }}.</p>
                        </div>

                        @include('errors.success')

                        <form method="POST" action="{{ route('join.update', ['id' => $user->id]) }}" class="form-border">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="text-white text-xs font-bold uppercase tracking-widest mb-2 block">{{ __('Name') }}</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="{{ __('Name') }}" required>
                                @error('name')
                                    <span class="red text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="text-white text-xs font-bold uppercase tracking-widest mb-2 block">{{ __('Email') }}</label>
                                <input type="email" value="{{ $user->email }}" class="form-control" disabled readonly style="opacity: 0.7; cursor: not-allowed;">
                            </div>

                            <div class="mb-4">
                                <label class="text-white text-xs font-bold uppercase tracking-widest mb-2 block">{{ __('Password') }}</label>
                                <input type="password" name="newPassword" class="form-control" placeholder="{{ __('Password') }}" required autofocus>
                                @error('newPassword')
                                    <span class="red text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="text-white text-xs font-bold uppercase tracking-widest mb-2 block">{{ __('Confirm Password') }}</label>
                                <input type="password" name="confirmPassword" class="form-control" placeholder="{{ __('Confirm Password') }}" required>
                                @error('confirmPassword')
                                    <span class="red text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn-main w-100 py-3">{{ __('Save Password & Join') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="spacer-double"></div>
        </div>
    </section>
</x-layouts.guest>
