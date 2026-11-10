<?php

namespace Database\Seeders;

use App\Models\SmsTemplate;
use Illuminate\Database\Seeder;

class SmsTemplateSeeder extends Seeder
{
    public function run(): void
    {
        SmsTemplate::updateOrCreate(
            ['type' => 'job_view'],
            [
                'body' => json_encode([
                    'sq' => "--- GEMELLI GARAGE ---\n\nPërshëndetje *{name}*,\n\nNdiqni punën dhe detajet e mjetit tuaj në këtë link:\n{link_view}\n\nFaleminderit!",
                    'it' => "--- GEMELLI GARAGE ---\n\nCiao *{name}*,\n\nClicca sul link sottostante per visualizzare i dettagli del tuo veicolo:\n{link_view}\n\nGrazie!",
                    'en' => "--- GEMELLI GARAGE ---\n\nHello *{name}*,\n\nClick the link below to view your vehicle details:\n{link_view}\n\nThank you!",
                ], JSON_UNESCAPED_UNICODE),
                'is_active' => true,
            ]
        );

        SmsTemplate::updateOrCreate(
            ['type' => 'reminder'],
            [
                'body' => json_encode([
                    'sq' => "Përshëndetje *{name}*,\n\nJu kujtojmë takimin tuaj për shërbim te Gemelli Garage në orën {time}.\n\nKonfirmo: {link_confirm} ose Anullo: {link_cancel}",
                    'it' => "Ciao *{name}*,\n\nTi ricordiamo il tuo appuntamento per il servizio presso Gemelli Garage alle ore {time}.\n\nConferma: {link_confirm} o Annulla: {link_cancel}",
                    'en' => "Hello *{name}*,\n\nReminder for your service appointment at Gemelli Garage at {time}.\n\nConfirm: {link_confirm} or Cancel: {link_cancel}",
                ], JSON_UNESCAPED_UNICODE),
                'is_active' => true,
            ]
        );

        SmsTemplate::updateOrCreate(
            ['type' => 'completed'],
            [
                'body' => json_encode([
                    'sq' => "Përshëndetje *{name}*,\n\nPuna për mjetin tuaj u përfundua me sukses! Mjeti është gati për t'u marrë te Gemelli Garage.\n\nFaleminderit!",
                    'it' => "Ciao *{name}*,\n\nI lavori sul tuo veicolo sono stati completati con successo! L'auto è pronta per il ritiro presso Gemelli Garage.\n\nGrazie!",
                    'en' => "Hello *{name}*,\n\nWork on your vehicle is complete! Your car is ready for pick up at Gemelli Garage.\n\nThank you!",
                ], JSON_UNESCAPED_UNICODE),
                'is_active' => true,
            ]
        );

        SmsTemplate::updateOrCreate(
            ['type' => 'promotional'],
            [
                'body' => json_encode([
                    'sq' => "Përshëndetje *{name}*,\n\nPërfitoni 15% ulje këtë muaj për shërbimet e Detailing dhe Wrapping te Gemelli Garage.\n\nNa kontaktoni për rezervim!",
                    'it' => "Ciao *{name}*,\n\nApprofitta del 15% di sconto questo mese sui servizi di Detailing e Wrapping presso Gemelli Garage.\n\nContattaci per prenotare!",
                    'en' => "Hello *{name}*,\n\nGet 15% off this month on Detailing and Wrapping services at Gemelli Garage.\n\nContact us to book!",
                ], JSON_UNESCAPED_UNICODE),
                'is_active' => true,
            ]
        );
    }
}
