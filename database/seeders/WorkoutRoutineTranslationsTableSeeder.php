<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkoutRoutine;
use App\Models\WorkoutRoutineTranslation;
class WorkoutRoutineTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        WorkoutRoutine::all()->each(function ($routine) {
            $translation = factory(WorkoutRoutineTranslation::class)->make([
                'language_code' => 'de',
            ]);

            $routine->translations()->save($translation);
        });
    }
}
