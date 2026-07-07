<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create default branch
        $branch = Branch::firstOrCreate(
            ['code' => 'PST'],
            [
                'name'      => 'Cabang Pusat',
                'address'   => 'Jl. Merdeka No. 1, Jakarta',
                'phone'     => '021-1234567',
                'is_active' => true,
            ]
        );

        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@odot.test'],
            [
                'name'      => 'Administrator',
                'password'  => Hash::make('password'),
                'phone'     => '081234567890',
                'branch_id' => $branch->id,
            ]
        );
        $admin->assignRole('admin');

        // Owner/Pemilik user
        $owner = User::firstOrCreate(
            ['email' => 'pemilik@odot.test'],
            [
                'name'      => 'Pemilik Toko',
                'password'  => Hash::make('password'),
                'phone'     => '081298765432',
                'branch_id' => $branch->id,
            ]
        );
        $owner->assignRole('pemilik');
    }
}
