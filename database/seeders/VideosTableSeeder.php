<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Video;
class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Video::factory()->count(1)->create();
    }
}
