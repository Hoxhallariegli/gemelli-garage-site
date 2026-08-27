@include('errors.errors')

@foreach (session('flash_notification', collect())->toArray() as $message)
    <div class="{{ $message['level'] == 'danger' ? 'red' : 'green' }} mb-3">{{ $message['message'] }}</div>
@endforeach

{{ session()->forget('flash_notification') }}

@if (session('message'))
    <div class="green mb-3">{{ session('message') }}</div>
@endif

@if (session('status'))
    <div class="green mb-3">{{ session('status') }}</div>
@endif
