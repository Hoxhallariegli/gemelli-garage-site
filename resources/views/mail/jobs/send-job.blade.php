@component('mail::message')
<div align="center" style="margin-bottom: 30px;">
    <a href="{{ config('app.url') }}" target="_blank" style="text-decoration: none;">
        <img src="https://blogger.googleusercontent.com/img/a/AVvXsEiaJJ0nfmKj_FeVbFeJo_rz316aYl7kTsdDYLhVCXTnCG9okJEryslhQYDo5u0ou2asITHwH_hnnYm97bP8HH8fu2R1G2JicvLP1v7gMoKIfjbGkz5v1g4GZeM9j69Ey8bf5JudG9wuHV-L0aYF37EW6YAS6dB1V39J_qaF16oQdqJo57exIkq_MI91ctW_=s16000" width="280" style="display: block; border: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;" alt="Gemelli Garage">
    </a>
</div>

# {{ __('jobs.whatsapp_greeting') }} {{ $job->car->client->name }},

{{ __('jobs.Please find your :doc for vehicle :brand :model with plate :plate.', [
    'doc' => $job->status == 'pending' ? __('jobs.quote') : __('jobs.invoice'),
    'brand' => $job->car->brand->name,
    'model' => $job->car->model->name,
    'plate' => $job->car->license_plate
]) }}

{{ __('jobs.Click the button below to view the full document and all service details.') }}

@component('mail::button', ['url' => $url, 'color' => 'success'])
{{ __('jobs.View Full Document') }}
@endcomponent

{{ __('jobs.Thanks for choosing us') }}

© {{ date('Y') }} {{ config('app.name') }}. {{ __('reports.Description') }}
@endcomponent
