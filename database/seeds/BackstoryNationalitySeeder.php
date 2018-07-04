<?php

use Illuminate\Database\Seeder;

class BackstoryNationalitySeeder extends Seeder
{
    private $nationalities = [
        'Aestivan League' => 'Aestivan',
        'Altene'          => 'Altene',
        'Cinera'          => 'Cineran',
        'Gadaene'         => 'Gadaene',
        'Iridine'         => 'Iridinian',
        'The Steps'       => 'from The Steps',
        'Parcines'        => 'Parcine',
        'Safelands'       => 'Safelander',
        'Sostaera'        => 'Sostaeran',
        'Tuchea'          => 'Tuchean',
        'Windward'        => 'Windwardian',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->nationalities)->each(function (string $nationality) {
            \App\Models\BackstoryNationality::create([
                'text' => $nationality,
            ]);
        });
    }
}
