<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 1)->create(['name' => 'admin', 'email' => 'admin@site.com']);
        factory(App\Influencer::class, 250)->create();
    }
}
