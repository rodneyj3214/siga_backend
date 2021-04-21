<?php

namespace Database\Seeders;

use App\Models\App\Authority;
use App\Models\App\AuthorityType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AuthenticationSeeder::class,
        ]);
    }
}
