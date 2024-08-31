<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuestUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'guest@example.com'],
            [
                'name' => 'guestuser',
                'password' => Hash::make('guestpass0406'),
                'provider' => 'guest',
                'provider_id' => 'guest'
            ]
        );
    }
}
