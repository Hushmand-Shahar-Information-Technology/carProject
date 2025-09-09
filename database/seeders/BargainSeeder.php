<?php

namespace Database\Seeders;

use App\Models\Bargain;
use Illuminate\Database\Seeder;

class BargainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bargains = [
            [
                'name' => 'Ahmed Khan',
                'username' => 'ahmed_property',
                'email' => 'ahmed@example.com',
                'website' => 'https://ahmed-properties.com',
                'phone' => '+93701234567',
                'whatsapp' => '+93701234567',
                'address' => 'Kabul, Afghanistan',
                'contract_start_date' => '2024-01-01',
                'contract_end_date' => '2024-12-31',
                'status' => 'more-time',
                'registration_status' => 'approved',
                'restriction_count' => 0,
            ],
            [
                'name' => 'Hassan Ali',
                'username' => 'hassan_real_estate',
                'email' => 'hassan@example.com',
                'website' => 'https://hassan-realestate.com',
                'phone' => '+93702345678',
                'whatsapp' => '+93702345678',
                'address' => 'Herat, Afghanistan',
                'contract_start_date' => '2024-02-01',
                'contract_end_date' => '2024-12-31',
                'status' => 'one-time',
                'registration_status' => 'pending',
                'restriction_count' => 0,
            ],
            [
                'name' => 'Mohammad Rahman',
                'username' => 'mohammad_properties',
                'email' => 'mohammad@example.com',
                'website' => 'https://mohammad-properties.com',
                'phone' => '+93703456789',
                'whatsapp' => '+93703456789',
                'address' => 'Mazar-i-Sharif, Afghanistan',
                'contract_start_date' => '2024-03-01',
                'contract_end_date' => '2024-12-31',
                'status' => 'more-time',
                'registration_status' => 'restricted',
                'restriction_count' => 2,
                'status_reason' => 'Restriction #2 - Account will be blocked after 3 restrictions',
            ],
            [
                'name' => 'Omar Farid',
                'username' => 'omar_blocked',
                'email' => 'omar@example.com',
                'website' => 'https://omar-properties.com',
                'phone' => '+93704567890',
                'whatsapp' => '+93704567890',
                'address' => 'Kandahar, Afghanistan',
                'contract_start_date' => '2024-04-01',
                'contract_end_date' => '2024-12-31',
                'status' => 'one-time',
                'registration_status' => 'blocked',
                'restriction_count' => 3,
                'status_reason' => 'Account blocked by administrator',
            ],
            [
                'name' => 'Rashid Ahmad',
                'username' => 'rashid_pending',
                'email' => 'rashid@example.com',
                'website' => null,
                'phone' => '+93705678901',
                'whatsapp' => '+93705678901',
                'address' => 'Jalalabad, Afghanistan',
                'contract_start_date' => '2024-05-01',
                'contract_end_date' => '2024-12-31',
                'status' => 'one-time',
                'registration_status' => 'pending',
                'restriction_count' => 0,
            ],
        ];

        foreach ($bargains as $bargainData) {
            $bargain = new Bargain($bargainData);
            
            // Generate registration number
            $lastId = Bargain::max('id') ?? 0;
            $bargain->registration_number = 'TM-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
            $bargain->edit_frequent = 0;
            
            if (isset($bargainData['status_reason'])) {
                $bargain->status_updated_at = now();
            }
            
            $bargain->save();
        }

        $this->command->info('Bargain seeder completed! Created ' . count($bargains) . ' bargains with different statuses.');
    }
}