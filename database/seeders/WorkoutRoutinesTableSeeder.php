<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;
use App\Models\LevelTag;
use App\Models\WorkoutRoutine;

class WorkoutRoutinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $offices = Office::all();
        $offices->shift();
        $office = $offices->shift();
        $levelTag = LevelTag::all()->find(3);

        factory(WorkoutRoutine::class, 5)->make()->each(function ($routine) use ($office, $levelTag) {
            $routine->levelTag()->associate($levelTag);
            $routine->office()->associate($office)->save();
        });
    }
}
