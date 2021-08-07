<?php
namespace Database\Seeders;

use App\Models\AthleteGroupSport;
use Illuminate\Database\Seeder;

class AthleteGroupSportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.default']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.soccer']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.handball']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.basketball']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.volleyball']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.hockey']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.gymnastics']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.tennis']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.running']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.athletics']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.golf']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.swimming']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.ski']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.cycling']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.table-tennis']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.badminton']);
        AthleteGroupSport::create(['i18n' => 'db.athlete.group.sport.other']);
    }
}
