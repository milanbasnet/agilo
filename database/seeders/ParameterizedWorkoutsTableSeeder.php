<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Workout;
use App\Models\WorkoutRoutine;
use App\Models\ParameterizedWorkout;

class ParameterizedWorkoutsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $workouts = Workout::all();

        WorkoutRoutine::all()->each(function ($routine) use ($workouts) {
            $parameterizedWorkouts = ParameterizedWorkout::factory()->count(,mt_rand(2, 5))->create();

            $parameterizedWorkouts->each(function ($parameterizedWorkout) use ($workouts, $routine) {
                $parameterizedWorkout
                    ->workout()->associate($workouts->random())
                    ->routine()->associate($routine)
                    ->save();
            });
        });
    }
}
