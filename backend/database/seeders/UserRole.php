<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\User;

class UserRole extends Seeder
{
    public function run(): void
    {
        $user_role = [
            [
                'user_id' => 1, 
                'role_id' => 1,
            ],
        ];
        
        foreach ($user_role as $u_r) {

            $user = User::find($u_r['user_id']);

            if ($user) {
                $user->roles()->sync([$u_r['role_id']]);
                $user->save();
            }
        }
    }
}
