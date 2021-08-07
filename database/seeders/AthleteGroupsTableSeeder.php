<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;
use App\Models\AthleteGroup;
use App\Models\AthleteGroupLevel;
use App\Models\AthleteGroupSport;
use App\Models\User;


class AthleteGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Office::all()->each(function ($office) {
            AthleteGroup::factory()->count(10)->make()->each(function ($group) use ($office) {
                $group->office()->associate($office);

                $level = AthleteGroupLevel::all()->first();
                $group->level()->associate($level);

                $sport = AthleteGroupSport::all()->first();
                $group->sport()->associate($sport);


                $officeUsers = User::whereOfficeId($office->id)
                    ->with('role')
                    ->get();

                $officeTherapist = $officeUsers
                    ->where('role.name', 'therapist')
                    ->first();

                if (!$officeTherapist) {
                    return;
                }

                $group->save();

                $group->users()->save($officeTherapist);

            });
        });
    }
}
