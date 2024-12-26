<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password123'), // Hash the password
            'firstName' => 'John',
            'lastName' => 'Doe',
            'frontIdPic' => 'front_id_pic_path',
            'backIdPic' => 'back_id_pic_path',
            'userStatus' => 'notVerified',
            'registrationStatus' => 'pending',
            'CV' => 'cv_path',
            'bio' => 'Bio of the user',
            'linkedinURL' => 'https://linkedin.com/in/johndoe',
            'skills' => 'PHP, Laravel',
        ]);
    }
}
