<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Clinic;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if(empty(User::count())) {    
            User::factory()->create([
                'name' => 'Test Doctor',
                'email' => 'test@test.com',
                'password' => Hash::make(1234),
            ]);
            User::factory(10)->create();
        }

        if(empty(Clinic::count())) {
            $clinic = Clinic::create([
                'name' => 'Test Clinic',
                'address' => '123 Test St',
            ]);
            User::where('id', 1)->first()->clinics()->attach($clinic);
        }

    }
}
