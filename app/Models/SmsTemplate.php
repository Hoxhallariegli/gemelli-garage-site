<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsTemplate extends Model
{
    use HasFactory, \App\Models\Traits\BelongsToGarage;

    protected $fillable = [
        'tenant_id',
        'type',
        'body',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getBodyForLang(?string $lang = null): string
    {
        $lang = $lang ?: app()->getLocale();

        if (is_array($this->body)) {
            return $this->body[$lang] ?? $this->body['sq'] ?? $this->body['it'] ?? reset($this->body) ?? '';
        }

        $decoded = json_decode((string)$this->body, true);
        if (is_array($decoded)) {
            return $decoded[$lang] ?? $decoded['sq'] ?? $decoded['it'] ?? reset($decoded) ?? '';
        }

        return (string) $this->body;
    }

    public static function getTemplate(string $type, ?string $lang = null): string
    {
        $template = self::where('type', $type)->where('is_active', true)->first();
        if (!$template) return '';

        return $template->getBodyForLang($lang);
    }
}
