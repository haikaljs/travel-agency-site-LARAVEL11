<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obj = new Admin;
        $obj->name = "admin";
        $obj->email = "admin@gmail.com";
        $obj->photo = "admin.jpg";
        $obj->password = Hash::make('12345678');
        $obj->token = "";
        $obj->save();
    }
}
