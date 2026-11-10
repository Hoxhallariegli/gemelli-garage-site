<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, \App\Models\Traits\BelongsToGarage;

    protected $fillable = ['tenant_id', 'public_token', 'car_id', 'service_id', 'material_id', 'meters_used', 'final_price', 'status', 'job_date', 'notes', 'email_sent_at', 'whatsapp_sent_at'];

    protected static function booted()
    {
        static::creating(function ($job) {
            $job->public_token = (string) \Illuminate\Support\Str::uuid();
        });
    }

    protected function casts(): array { return [
            'meters_used' => 'decimal:2',
            'final_price' => 'decimal:2',
            'job_date' => 'datetime',
            'email_sent_at' => 'datetime',
            'whatsapp_sent_at' => 'datetime',
        ]; }
    public static function rules($id = null): array { return [
            'car_id' => ['required', 'integer'],
            'service_id' => ['nullable', 'integer'],
            'material_id' => ['nullable', 'integer'],
            'meters_used' => ['nullable', 'numeric'],
            'final_price' => ['nullable', 'numeric'],
            'status' => ['required', \Illuminate\Validation\Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
            'job_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]; }
    public static function sortable(): array { return ['id', 'car_id', 'service_id', 'final_price', 'status', 'job_date']; }

    public function car(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\Car::class, 'car_id'); }

    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo { return $this->belongsTo(\App\Models\Service::class, 'service_id'); }

    public function services()
    {
        return $this->hasMany(JobService::class);
    }

    public function materials()
    {
        return $this->hasMany(JobMaterial::class);
    }

    public function parts()
    {
        return $this->hasMany(JobPart::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function getPaidAmountAttribute()
    {
        return (float) $this->payments->sum('amount');
    }

    public function getRemainingBalanceAttribute()
    {
        return $this->gross_revenue - $this->paid_amount;
    }

    public function getPaymentStatusAttribute()
    {
        if ($this->paid_amount <= 0) return 'unpaid';
        if ($this->remaining_balance <= 0) return 'paid';
        return 'partial';
    }

    public function getGrossRevenueAttribute()
    {
        $serviceRevenue = $this->services->sum('price');
        $materialRevenue = $this->materials->sum(fn($m) => $m->quantity * $m->sell_price);
        $partRevenue = $this->parts->sum(fn($p) => $p->quantity * $p->sell_price);

        // If it's a legacy job with only service_id and final_price
        $legacyRevenue = (!$serviceRevenue && $this->final_price > 0) ? (float)$this->final_price : 0;

        return $serviceRevenue + $materialRevenue + $partRevenue + $legacyRevenue;
    }

    public function getTotalCostAttribute()
    {
        $materialCost = $this->materials->sum(fn($m) => $m->quantity * $m->cost_price);
        $partCost = $this->parts->sum(fn($p) => $p->quantity * $p->cost_price);
        return (float) $materialCost + (float) $partCost;
    }

    public function getNetProfitAttribute()
    {
        return $this->gross_revenue - $this->total_cost;
    }

    public function getBodyTypeImageAttribute()
    {
        return $this->car?->body_type_image;
    }

    public function getWhatsappUrlAttribute()
    {
        $client = $this->car?->client;
        if (!$client?->phone) return '#';

        $phone = preg_replace('/[^0-9]/', '', $client->phone);
        if (str_starts_with($phone, '0')) {
            $phone = '355' . substr($phone, 1);
        }

        $url = route('public.job.view', [
            'token' => $this->public_token,
            'lang' => app()->getLocale(),
            'v' => time()
        ]);

        $docType = $this->status === 'pending' ? __('jobs.quote') : __('jobs.invoice');

        $message = $this->generateWhatsappMessage();

        return 'https://wa.me/' . $phone . '?' . http_build_query(['text' => $message], '', '&', PHP_QUERY_RFC3986);
    }

    public function generateWhatsappMessage(): string
    {
        $client = $this->car?->client;
        $url = route('public.job.view', [
            'token' => $this->public_token,
            'lang' => app()->getLocale(),
            'v' => time()
        ]);

        $garageName = mb_strtoupper($this->garage?->name ?? 'GEMELLI GARAGE');
        $docType = $this->status === 'pending' ? __('jobs.quote') : __('jobs.invoice');
        $clientName = $client->name ?? __('workdesk.Client');

        // Check if template exists in DB
        $templateBody = \App\Models\SmsTemplate::getTemplate('job_view');

        if ($templateBody) {
            return str_replace(
                ['{name}', '{link_view}', '{garage}', '{doc}'],
                [$clientName, $url, $garageName, $docType],
                $templateBody
            );
        }

        return "--- {$garageName} ---\n\n" .
               __('jobs.whatsapp_greeting') . " *" . $clientName . "*,\n\n" .
               __('jobs.Click the link below to view the :doc and your vehicle details:', ['doc' => $docType]) . "\n\n" .
               $url;
    }

    public function sendWhatsAppNotification(): bool
    {
        $client = $this->car?->client;
        if (!$client?->phone) return false;

        /** @var \App\Services\WhatsAppService $service */
        $service = app(\App\Services\WhatsAppService::class);
        $message = $this->generateWhatsappMessage();

        $sent = $service->send(
            phone: $client->phone,
            message: $message,
            tenantId: $this->tenant_id ?? auth()->user()?->tenant_id ?? 1,
            clientId: $client->id,
            templateType: 'job_view'
        );

        if ($sent) {
            $this->update(['whatsapp_sent_at' => now()]);
        }

        return $sent;
    }
}
