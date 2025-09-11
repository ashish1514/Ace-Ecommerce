<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
   
    public function run(): void
    {
        $permissions =[
            "user.show",
            "user.create",
            "user.edit",
            "user.delete",
            "role.show",
            "role.create",
            "role.edit",
            "role.delete",
            "product.show",
            "product.create",
            "product.edit",
            "product.delete"
        ];
        foreach($permissions as $key => $value)
        {
            Permission::create(['name' => $value]);
        }
    }
}
