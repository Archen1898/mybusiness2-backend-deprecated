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
            'avatar'=>'6447398.png',
            'active'=>1
        ])->assignRole(['Administrator']);

        User::create([
            'name'=>'Yeneidys',
            'user_name'=>'yalvarezg',
            'first_name'=>'Alvarez',
            'last_name'=>'Gonzalez',
            'email'=>'yalvarezg@fiu.edu',
            'password'=>bcrypt('12345678'),
            'panther_id'=>'12345677',
            'avatar'=>'12345677.png',
            'active'=>1,
            'instructor'=>0,
            'student'=>0
        ])->assignRole(['Instructor']);
        User::create([
            'name'=>'Kamil',
            'user_name'=>'kamil',
            'first_name'=>'Gonzalez',
            'last_name'=>'Alvarez',
            'email'=>'kamil@fiu.edu',
            'password'=>bcrypt('12345678'),
            'panther_id'=>'12345676',
            'avatar'=>'12345676.png',
            'active'=>1,
            'instructor'=>1,
            'student'=>0
        ])->assignRole(['Instructor']);

        User::create([
            'name'=>'Kevin',
            'user_name'=>'kevin',
            'first_name'=>'Gonzalez',
            'last_name'=>'Alvarez',
            'email'=>'kevin@fiu.edu',
            'password'=>bcrypt('12345678'),
            'panther_id'=>'12345675',
            'avatar'=>'12345675.png',
            'active'=>1,
            'instructor'=>1,
            'student'=>0
        ])->assignRole(['Instructor']);

        User::create([
            'name'=>'Mercedes',
            'user_name'=>'mercedes',
            'first_name'=>'Gonzalez',
            'last_name'=>'Santiesteban',
            'email'=>'mercedes@fiu.edu',
            'password'=>bcrypt('12345678'),
            'panther_id'=>'12345674',
            'avatar'=>'12345674.png',
            'active'=>1,
            'instructor'=>1,
            'student'=>0
        ])->assignRole(['Instructor']);

        User::create([
            'name'=>'Margot',
            'user_name'=>'margot',
            'first_name'=>'Gonzalez',
            'last_name'=>'Quintana',
            'email'=>'margot@fiu.edu',
            'password'=>bcrypt('12345678'),
            'panther_id'=>'12345673',
            'avatar'=>'12345673.png',
            'active'=>1,
            'instructor'=>1,
            'student'=>0
        ])->assignRole(['Instructor']);

        User::create([
            'name'=>'Fidel',
            'user_name'=>'alvares',
            'first_name'=>'Alvares',
            'last_name'=>'Marin',
            'email'=>'alvares@fiu.edu',
            'password'=>bcrypt('12345678'),
            'panther_id'=>'12345672',
            'avatar'=>'12345672.png',
            'active'=>1,
            'instructor'=>0,
            'student'=>0
        ])->assignRole(['Support']);

        User::create([
            'name'=>'Aurelio',
            'user_name'=>'marinez',
            'first_name'=>'Alvares',
            'last_name'=>'Marin',
            'email'=>'marinez@fiu.edu',
            'password'=>bcrypt('12345678'),
            'panther_id'=>'12345671',
            'avatar'=>'12345671.png',
            'active'=>1,
            'instructor'=>0,
            'student'=>0
        ])->assignRole(['Manager']);

        User::create([
            'name'=>'Ricardo',
            'user_name'=>'ricardo',
            'first_name'=>'Fonseca',
            'last_name'=>'Marin',
            'email'=>'ricardo@fiu.edu',
            'password'=>bcrypt('12345678'),
            'panther_id'=>'12345670',
            'avatar'=>'12345670.png',
            'active'=>1,
            'instructor'=>0,
            'student'=>0
        ])->assignRole(['Secretary']);

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
