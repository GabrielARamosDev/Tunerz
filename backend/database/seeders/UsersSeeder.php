<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id' => 1, 
                'name' => 'Gabriel do Amaral Ramos', 
                'email' => 'gabrihot79@gmail.com', 
                'email_verified_at' => now(), 
                'password' => Hash::make('1234'), 
                'remember_token' => '', 
                'created_at' => now(), 
                'updated_at' => now(), 
            ],
        ];
        
        foreach ($users as $u) {
            User::updateOrCreate([ 'id' => $u['id'] ], $u);
        }
    }
}

