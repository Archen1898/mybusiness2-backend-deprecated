<?php

namespace Database\Seeders;

//GLOBAL IMPORT
use Illuminate\Database\Seeder;

//LOCAL IMPORT
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Salvador',
            'user_name'=>'sgonzalezg',
            'first_name'=>'Gonzalez',
            'last_name'=>'Gomez',
            'email'=>'admin@fiu.edu',
            'password'=>bcrypt('12345678'),
            'panther_id'=>'6447398',
            'avatar'=>'./../avatar',
            'active'=>1
        ])->assignRole(['Administrator']);
//        User::create([
//            'name'=>'Demo',
//            'email'=>'demo@fiu.edu',
//            'password'=>bcrypt('12345678'),
//            'panther_id'=>'6447399',
//            'avatar'=>'./../avatar',
//            'active'=>1
//        ])->givePermissionTo('Dashboard.','Profile.');
    }
}
