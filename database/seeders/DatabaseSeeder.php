<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // $users = User::factory(2)->create();
        // // User::factory(10)->create();
        // $users->each(function ($user) {
        //     Listing::factory(5)->create([
        //         'owner_id' => $user->id,
        //     ]);
        // });


        $users = [
            User::factory()->create([
                'name' => 'Jean',
                'email' => 'jean@email.com',
                'password' => 'password1',
                'is_admin' => true
            ]),
            User::factory()->create([
                'name' => 'Scott',
                'email' => 'scott@email.com',
                'password' => 'password1',
                'is_admin' => false
            ])
        ];


        foreach ($users as $user) {
            Listing::factory(20)->create([
                'owner_id' => $user->id
            ]);
        }




    }
}