<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;


class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'users-list',
            'users-create',
            'users-delete',
            'users-update',
            'user-show',
            'books-list',
            'book-show',
            'books-create',
            'books-delete',
            'books-update',
            'mainCategory-create',
            'subCategory-create',
            'mainCategory-delete',
            'subCategory-delete',
            'addToFavorite',
            'addRating',
            'selectByMainCategory',
            'selectBySubCategory',
        ];
        foreach ($permissions as $permission ) {
          Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'admin'])->givePermissionTo($permissions);

        Role::create(['name' => 'member'])->givePermissionTo([
            'user-show',
            'books-list',
            'book-show',
            'addToFavorite',
            'addRating',
            'selectByMainCategory',
            'selectBySubCategory'
        ]);

        Role::create(['name' => 'visitor'])->givePermissionTo([
            'books-list',
            'book-show',
            'selectByMainCategory',
            'selectBySubCategory'
        ]);
}
}
