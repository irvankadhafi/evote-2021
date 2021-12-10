<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->first_name = "Irvan";
        $admin->last_name = "Kadhafi";
        $admin->email = "irvankadhafi04@gmail.com";
        $admin->password = Hash::make('irvan456');
        $admin->owner=1;
        $admin->save();
    }
}
