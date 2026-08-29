<?php

namespace Database\Seeders;

use App\Models\SmsTemplate;
use Illuminate\Database\Seeder;

class SmsTemplateSeeder extends Seeder
{
    public function run(): void
    {
        SmsTemplate::updateOrCreate(
            ['type' => 'confirmation'],
            [
                'body' => 'Pershendetje {name}, rezervimi juaj ne orën {time} u krye me sukses tek Gemelli Garage. Ju faleminderit!',
                'is_active' => true,
            ]
        );

        SmsTemplate::updateOrCreate(
            ['type' => 'reminder'],
            [
                'body' => 'Pershendetje {name}, pas 30 minutash (ne oren {time}) keni takimin tek Gemelli Garage. Konfirmo: {link_confirm} ose Anulo: {link_cancel}',
                'is_active' => true,
            ]
        );

        SmsTemplate::updateOrCreate(
            ['type' => 'promotional'],
            [
                'body' => 'Pershendetje {name}, keni nje oferte te re nga Gemelli Garage! Na vizitoni ne website-in tone.',
                'is_active' => true,
            ]
        );
    }
}
