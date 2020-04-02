<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::truncate();

        factory(App\User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'activated' => 1
        ]);

        factory(App\User::class)->create([
            'name' => 'aaa',
            'email' => 'aaa@aaa.aaa',
            'activated' => 1
        ]);

        factory(App\User::class, 2)->create();

        // App\User::create([
        //     'name' => sprintf('%s', Str::random(4)),
        //     'email' => Str::random(5) . '@exam.com',
        //     'password' => bcrypt('1111'),
        // ]);        
    }    
}
