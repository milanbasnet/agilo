<?php
namespace Database\Seeders;

use App\Models\AthleteGroupLevel;
use Illuminate\Database\Seeder;

class AthleteGroupLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        AthleteGroupLevel::create(['i18n' => 'db.athlete.group.level.recreational']);
        AthleteGroupLevel::create(['i18n' => 'db.athlete.group.level.club']);
        AthleteGroupLevel::create(['i18n' => 'db.athlete.group.level.regional']);
        AthleteGroupLevel::create(['i18n' => 'db.athlete.group.level.national']);
        AthleteGroupLevel::create(['i18n' => 'db.athlete.group.level.international']);
    }
}
