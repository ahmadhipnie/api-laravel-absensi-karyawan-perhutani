<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'npk' => 'ADM001',
            'nama' => 'Admin User',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Sample Employees
        $employees = [
            ['npk' => 'EMP001', 'nama' => 'John Doe'],
            ['npk' => 'EMP002', 'nama' => 'Jane Smith'],
            ['npk' => 'EMP003', 'nama' => 'Bob Johnson'],
            ['npk' => 'EMP004', 'nama' => 'Alice Williams'],
            ['npk' => 'EMP005', 'nama' => 'Charlie Brown'],
        ];

        foreach ($employees as $employee) {
            User::create([
                'npk' => $employee['npk'],
                'nama' => $employee['nama'],
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ]);
        }
    }
}
