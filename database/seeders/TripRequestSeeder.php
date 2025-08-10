<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TripRequest;

class TripRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TripRequest::create([
            'request_number' => 'TR2023-001',
            'user_id' => 2, // أحمد محمد
            'destination_id' => 1, // تركيا
            'travel_date' => '2023-09-15',
            'duration_days' => 7,
            'travelers_count' => 2,
            'notes' => 'رحلة شهر العسل، نريد فندق 5 نجوم',
            'status' => 'pending',
        ]);

        TripRequest::create([
            'request_number' => 'TR2023-002',
            'user_id' => 3, // فاطمة عبدالله
            'destination_id' => 2, // ماليزيا
            'travel_date' => '2023-08-20',
            'duration_days' => 10,
            'travelers_count' => 4,
            'notes' => 'رحلة عائلية مع الأطفال',
            'status' => 'processing',
        ]);

        TripRequest::create([
            'request_number' => 'TR2023-003',
            'user_id' => 4, // خالد سعيد
            'destination_id' => 3, // جورجيا
            'travel_date' => '2023-07-10',
            'duration_days' => 5,
            'travelers_count' => 1,
            'notes' => 'رحلة فردية للاستكشاف',
            'status' => 'completed',
        ]);

        TripRequest::create([
            'request_number' => 'TR2023-004',
            'user_id' => 5, // سارة عبدالرحمن
            'destination_id' => 4, // إندونيسيا
            'travel_date' => '2023-10-05',
            'duration_days' => 8,
            'travelers_count' => 2,
            'notes' => 'رحلة للاسترخاء والاستجمام',
            'status' => 'pending',
        ]);

        TripRequest::create([
            'request_number' => 'TR2023-005',
            'user_id' => 2, // أحمد محمد
            'destination_id' => 5, // تايلاند
            'travel_date' => '2023-11-20',
            'duration_days' => 12,
            'travelers_count' => 3,
            'notes' => 'رحلة مع الأصدقاء',
            'status' => 'approved',
        ]);
    }
}