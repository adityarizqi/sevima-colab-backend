<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Role::create([
            'name' => 'super_admin',
            'permissions' => json_encode([
                'users' => [
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => true,
                ],
                'roles' => [
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => true,
                ],
            ])
        ]);

        \App\Models\Role::create([
            'name' => 'admin',
            'permissions' => json_encode([
                'employees' => [
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => true,
                ],
                'roles' => [
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => true,
                ],
                'students' => [
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => true,
                ]
            ])
        ]);
    }
}
