<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $contactSettings = [
            [
                'key' => 'contact_whatsapp',
                'value' => '+6281234567890',
                'type' => 'string',
                'label' => 'WhatsApp Contact Number',
                'description' => 'Official WhatsApp number for support (e.g., +6281234567890).',
            ],
            [
                'key' => 'contact_email',
                'value' => 'contact@universitynews.edu',
                'type' => 'string',
                'label' => 'Contact Email Address',
                'description' => 'Official support and inquiry email.',
            ],
            [
                'key' => 'contact_address',
                'value' => "123 Academic Way, University Plaza\nAcademic Heights, ST 12345",
                'type' => 'string',
                'label' => 'Physical Address',
                'description' => 'Official university or organization physical address.',
            ],
        ];

        foreach ($contactSettings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['contact_whatsapp', 'contact_email', 'contact_address'])->delete();
    }
};
