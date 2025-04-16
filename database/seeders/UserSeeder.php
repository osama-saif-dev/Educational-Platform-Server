<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i=1; $i < 10; $i++) { 
            User::create([
                'id' => $i,
                'first_name' => "osama $i",
                'last_name' => "saif $i",
                'email' => "osamasaif24$i@gmail.com",
                'phone' => "0109021529$i",
                'password' => Hash::make("3546586$i"),
            ]);
        }
    }
}
