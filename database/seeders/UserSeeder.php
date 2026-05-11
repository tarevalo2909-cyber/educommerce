<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@educommerce.test'],
            ['name' => 'Administrador', 'password' => Hash::make('password'), 'is_active' => true]
        );
        $admin->syncRoles(['admin']);

        $teacher = User::firstOrCreate(
            ['email' => 'profesor@educommerce.test'],
            ['name' => 'Carlos Profesor', 'password' => Hash::make('password'), 'is_active' => true]
        );
        $teacher->syncRoles(['profesor']);

        $teacher2 = User::firstOrCreate(
            ['email' => 'profesor2@educommerce.test'],
            ['name' => 'Ana Profesora', 'password' => Hash::make('password'), 'is_active' => true]
        );
        $teacher2->syncRoles(['profesor']);

        $student = User::firstOrCreate(
            ['email' => 'estudiante@educommerce.test'],
            ['name' => 'Luis Estudiante', 'password' => Hash::make('password'), 'is_active' => true]
        );
        $student->syncRoles(['estudiante']);

        $student2 = User::firstOrCreate(
            ['email' => 'estudiante2@educommerce.test'],
            ['name' => 'María Estudiante', 'password' => Hash::make('password'), 'is_active' => true]
        );
        $student2->syncRoles(['estudiante']);
    }
}
