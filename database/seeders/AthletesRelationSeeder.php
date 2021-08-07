<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Athlete;
use App\Models\WorkoutRoutine;
use App\Models\AthleteGroup;


class AthletesRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $athletes = Athlete::all()->shuffle();
        $athletesWithRoutines = $athletes->take($athletes->count() / 2);
        $athletesWithGroups = $athletes->shuffle()->take($athletes->count() / 2);

        $routines = WorkoutRoutine::all();
        $groups = AthleteGroup::all();

        $athletesWithRoutines->each(function ($athlete) use ($routines) {
            $routines->shuffle()->take(mt_rand(1, 3))->each(function ($routine) use ($athlete) {
                $athlete->routines()->attach($routine);
            });
        });

        $athletesWithGroups->each(function ($athlete) use ($groups) {
            $groups->shuffle()->take(mt_rand(1, 3))->each(function ($group) use ($athlete) {
                $athlete->groups()->attach($group);
            });
        });
//
//        $routines = Agilo\TimedWorkoutRoutine::all();
//        $groups = Agilo\AthleteGroup::all();
//
//        $athletesWithRoutines->each(function ($athlete) use ($routines) {
//            $routines->shuffle()->take(mt_rand(1, 3))->each(function ($routine) use ($athlete) {
//                $athlete->timedRoutines()->attach($routine);
//            });
//        });
    }
}
