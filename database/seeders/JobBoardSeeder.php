<?php

namespace Database\Seeders;

use App\Models\App\Catalogue;
use App\Models\Authentication\User;
use App\Models\JobBoard\Skill;
use App\Models\JobBoard\Category;
use App\Models\JobBoard\Professional;
use Illuminate\Database\Seeder;

class JobBoardSeeder extends Seeder
{
    public function run()
    {
        $this->createProfessionals();
        $this->createCategories();
        $this->createTypeSkillCatalogues();
        $this->createSkills();
    }

    private function createProfessionals()
    {
        foreach (User::all() as $user) {
            $professional = new Professional();
            $professional->user()->associate($user);
            $professional->save();
        }
    }

    private function createCategories()
    {
        Category::factory()->count(5)->create();
    }

    private function createTypeSkillCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $softSkill = Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['skill_type']['soft'],
            'name' => 'HABILIDADES BLANDAS',
            'type' => $catalogues['catalogue']['skill_type']['type']
        ]);
        $hardSkill = Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['skill_type']['hard'],
            'name' => 'HABILIDADES DURAS',
            'type' => $catalogues['catalogue']['skill_type']['type']
        ]);
        Catalogue::factory()->count(10)->create([
            'parent_id' => $softSkill->id,
            'type' => $catalogues['catalogue']['skill_type']['type']
        ]);

        Catalogue::factory()->count(10)->create([
            'parent_id' => $hardSkill->id,
            'type' => $catalogues['catalogue']['skill_type']['type'],
        ]);
    }

    private function createSkills()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $professional = Professional::find(1);
        $types = Catalogue::where('type', $catalogues['catalogue']['skill_type']['type'])->where('parent_id', '<>', null);

        for ($i = 0; $i < 1; $i++) {
            foreach ($types as $type) {
                Skill::factory()->count(100)->create([
                    'professional_id' => $professional->id,
                    'type_id' => $type->id
                ]);
            }
        }
    }
}
