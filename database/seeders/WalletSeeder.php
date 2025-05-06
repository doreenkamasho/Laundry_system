<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wallet;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        Wallet::create([
            'user_id' => 6,
            'phone_number' => '255754318464',
            'balance' => 2000000.00,
            'provider' => 'vodacom',
            'is_active' => true
        ]);
    }
}
