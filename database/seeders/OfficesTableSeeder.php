<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfficeType;
use App\Models\Office;
class OfficesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $types = OfficeType::all();

        Office::factory()->count(5)->make()->each(function ($office) use ($types) {
            $office->type()->associate($types->first());
            $office->save();
        });
    }
}
