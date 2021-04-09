<?php

namespace Database\Seeders;

use App\Models\Authentication\User;
use App\Models\JobBoard\Category;
use App\Models\JobBoard\Professional;
use Illuminate\Database\Seeder;

class JobBoardSeeder extends Seeder
{
    public function run()
    {
        $this->createProfessionals();
        $this->createCategories();
    }

    private function createProfessionals()
    {
        foreach (User::all() as $user) {
            Professional::factory()->create([
                'user_id' => $user->id
            ]);
        }
    }

    private function createCategories()
    {
        Category::factory()->count(5)->create();
    }
}
