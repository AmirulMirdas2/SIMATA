<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@simata.com'], [
            'name' => 'Admin Terminal',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081122334455',
        ]);
        
        User::firstOrCreate(['email' => 'mitra@simata.com'], [
            'name' => 'Mitra PO Bus',
            'password' => Hash::make('password'),
            'role' => 'mitra',
            'phone' => '082233445566',
        ]);
        
        User::firstOrCreate(['email' => 'penumpang@simata.com'], [
            'name' => 'Penumpang Setia',
            'password' => Hash::make('password'),
            'role' => 'penumpang',
            'phone' => '083344556677',
        ]);
    }
}
