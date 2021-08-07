<?php
namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Equipment::create(['name' => 'Balance Board']);
        Equipment::create(['name' => 'Balance Pad']);
        Equipment::create(['name' => 'Pezziball']);
        Equipment::create(['name' => 'Gewicht/ Dumbbell']);
        Equipment::create(['name' => 'Kurzhantel [KG]']);
        Equipment::create(['name' => 'Langhantel [KG]']);
        Equipment::create(['name' => 'Pezziball']);
        Equipment::create(['name' => 'Kettleball [KG]']);
        Equipment::create(['name' => 'Medizinball [KG]']);
        Equipment::create(['name' => 'Performanceband']);
        Equipment::create(['name' => 'Theraband']);
        Equipment::create(['name' => 'Seil']);
        Equipment::create(['name' => 'Stepper']);
        Equipment::create(['name' => 'Jump Box']);
        Equipment::create(['name' => 'Sling Trainer']);
    }
}
