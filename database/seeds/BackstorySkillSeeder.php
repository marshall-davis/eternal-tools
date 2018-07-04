<?php

use Illuminate\Database\Seeder;

class BackstorySkillSeeder extends Seeder
{
    private $skills = [
        'archer',
        'brawler',
        'bar fighter',
        'cestus user',
        'cestus fanatic',
        'knifer',
        'knife user',
        'Cineran dirk expert',
        'axe user',
        'one-handed axe user',
        'two-handed axe user',
        'mace wielder',
        'truncheon master',
        'gladius swinger',
        'sword student',
        'Avros pupil',
        'Nelsor style sword user',
        'Pardelian',
        'pankrationist',
        'spear wielder',
        'staff spinner',
        'trident jabber',
        'fork fighter',
        'whipper',
        'locksmith',
        'healer',
        'medic',
        'tailor',
        'clothing fanatic',
        'survivalist',
        'outdoors person',
        'hunter',
        'trapper',
        'thief',
        'pickpocket',
        'cut purse',
        'vagabond',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->skills)->each(function (string $skill) {
            \App\Models\BackstorySkill::create([
                'text' => $skill,
            ]);
        });
    }
}
