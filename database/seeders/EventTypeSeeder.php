<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('event_types')->insert(
            [
                [
                    'name' => '初日',
                    'order' => 10,
                    'editable' => false,
                    'created_at' => now(),
                ],
                [
                    'name' => '最終日',
                    'order' => 20,
                    'editable' => false,
                    'created_at' => now(),
                ],
                [
                    'name' => '倍率',
                    'order' => 30,
                    'editable' => true,
                    'created_at' => now(),
                ],
            ]
        );
    }
}
