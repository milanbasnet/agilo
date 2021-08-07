<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Workout;
use App\Models\WorkoutTranslation;
class WorkoutTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
       Workout::all()->each(function ($workout) {
            $translation = WorkoutTranslation::factory()->make([
                'language_code' => 'de',
            ]);
            $workout->translations()->save($translation);
        });
    }
}
