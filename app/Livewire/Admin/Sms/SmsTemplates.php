<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sms;

use App\Models\SmsTemplate;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SmsTemplates extends Component
{
    public bool $showingModal = false;
    public ?int $templateId = null;

    public string $type = '';
    public array $body = [
        'sq' => '',
        'it' => '',
        'en' => '',
    ];
    public string $activeTab = 'sq';
    public bool $is_active = true;

    protected $rules = [
        'type' => 'required|string|max:255',
        'body.sq' => 'nullable|string',
        'body.it' => 'nullable|string',
        'body.en' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function render(): View
    {
        return view('livewire.admin.sms.sms-templates', [
            'templates' => SmsTemplate::all(),
            'locales' => [
                'sq' => 'Shqip 🇦🇱',
                'it' => 'Italiano 🇮🇹',
                'en' => 'English 🇬🇧',
            ],
        ])->layout('components.layouts.app');
    }

    public function create(): void
    {
        $this->reset(['type', 'templateId', 'is_active']);
        $this->body = [
            'sq' => '',
            'it' => '',
            'en' => '',
        ];
        $this->activeTab = 'sq';
        $this->showingModal = true;
    }

    public function edit(int $id): void
    {
        $template = SmsTemplate::findOrFail($id);
        $this->templateId = $id;
        $this->type = $template->type;

        $decoded = is_array($template->body) ? $template->body : json_decode((string)$template->body, true);

        if (is_array($decoded)) {
            $this->body = [
                'sq' => $decoded['sq'] ?? '',
                'it' => $decoded['it'] ?? '',
                'en' => $decoded['en'] ?? '',
            ];
        } else {
            $this->body = [
                'sq' => (string)$template->body,
                'it' => (string)$template->body,
                'en' => (string)$template->body,
            ];
        }

        $this->activeTab = 'sq';
        $this->is_active = $template->is_active;
        $this->showingModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $encodedBody = is_array($this->body)
            ? json_encode($this->body, JSON_UNESCAPED_UNICODE)
            : (string) $this->body;

        if ($this->templateId) {
            $template = SmsTemplate::find($this->templateId);
            if ($template) {
                $template->update([
                    'type' => $this->type,
                    'body' => $encodedBody,
                    'is_active' => $this->is_active,
                ]);
            }
        } else {
            SmsTemplate::create([
                'type' => $this->type,
                'body' => $encodedBody,
                'is_active' => $this->is_active,
            ]);
        }

        $this->showingModal = false;
        $this->dispatch('toast', message: __('Template saved successfully!'), type: 'success');
    }

    public function delete(int $id): void
    {
        SmsTemplate::findOrFail($id)->delete();
        $this->dispatch('toast', message: __('Template deleted.'), type: 'success');
    }
}
