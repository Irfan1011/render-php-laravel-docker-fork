<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = ([
            'name' => 'Manager',
            'email' => 'Manager@gmail.com',
            'password' => bcrypt('manager'),
            'email_verified_at' => now(),
        ]);
        User::create($manager);

        $path = public_path('/../database/SQL/Manager_Role.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
