<?php

namespace Database\Seeders;

use App\Constants\Roles;
use App\Models\Role;

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Roles::man();

        if (empty($roles)) {
            return;
        }
        
        foreach ($roles as $r) {
            Role::updateOrCreate([ 'id' => $r['id'] ], $r);
        }
    }
}
