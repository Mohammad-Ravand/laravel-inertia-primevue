<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name'=>'admin'
            ],
            [
                'name'=> 'customer'
            ],
            [
                'name'=>'guest'
            ],
        ];

        $roles= array_map(function($role){
            return [...$role,'created_at'=>now(),'updated_at'=>now()];
        },$roles);

        Role::insert($roles);
    }
}
