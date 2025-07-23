<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Times;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '123123',
        ]);

        Service::create([
            'name' => 'Dar entrada Nova CIN',
            'description' => 'Criação da Nova CIN + Rápida',
            'duration' => 30,
            'is_active' => true,
        ]);
        Service::create([
            'name' => 'Entrega de documento',
            'description' => 'Horário para retirada de documento',
            'duration' => 30,
            'is_active' => true,
        ]);

        // // Horário inicial
        // $startHour = 8;
        // $endHour = 14;

        // for ($hour = $startHour; $hour <= $endHour; $hour++) {
        //     // Criar horários cheios (ex: 08:00, 09:00)
        //     Times::create([
        //         'hour' => sprintf($hour) . ':00:00',
        //         'is_active' => true,
        //     ]);
        // }
    }
}
