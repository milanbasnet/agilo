<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;
use App\Models\Video;
use App\Models\PaceTag;
use App\Models\Workout;
use App\Models\Leveltag;


class WorkoutsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $office = Office::all()->first();
        $video = Video::all()->first();
        $paceTag =PaceTag::all()->find(2);
        $levelTag = LevelTag::all()->find(3);
        Workout::factory()->count(10)->make()->each(function ($workout) use ($office, $video, $paceTag, $levelTag) {
            $workout->office()->associate($office);
            $workout->video()->associate($video);
            $workout->paceTag()->associate($paceTag);
            $workout->levelTag()->associate($levelTag);
            $workout->save();
        });
    }
}
