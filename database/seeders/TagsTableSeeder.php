<?php
namespace Database\Seeders;

use App\Models\RegionTag;
use App\Models\TypeTag;
use App\Models\PaceTag;
use App\Models\AgeTag;
use App\Models\GenderTag;
use App\Models\MeasureTag;
use App\Models\ObjectiveTag;
use App\Models\LevelTag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        RegionTag::create(['name' => 'Kopf']);
        RegionTag::create(['name' => 'obere Extremität']);
        RegionTag::create(['name' => 'Nacken']);
        RegionTag::create(['name' => 'Schulter']);
        RegionTag::create(['name' => 'Core/ Rumpf']);
        RegionTag::create(['name' => 'Rücken']);
        RegionTag::create(['name' => 'unterer Rücken']);
        RegionTag::create(['name' => 'untere Extremität (Bein)']);
        RegionTag::create(['name' => 'Hüfte/Leiste']);
        RegionTag::create(['name' => 'Oberschenkel']);
        RegionTag::create(['name' => 'Knie']);
        RegionTag::create(['name' => 'Unterschenkel']);
        RegionTag::create(['name' => 'Sprunggelenk/Fuß']);
        RegionTag::create(['name' => 'ganzer Körper – (keine Spezifische Region)']);

        TypeTag::create(['name' => 'Kraft - dynamisch']);
        TypeTag::create(['name' => 'Kraft - isometrisch']);
        TypeTag::create(['name' => 'Kraft - exzentrisch']);
        TypeTag::create(['name' => 'Kraft - funktionell']);
        TypeTag::create(['name' => 'Kraft - explosiv']);
        TypeTag::create(['name' => 'Flexibilität - muskuläre Dehnung']);
        TypeTag::create(['name' => 'Flexibilität - Gelenkbeweglichkeit']);
        TypeTag::create(['name' => 'Flexibilität - Nervenmobilisation']);
        TypeTag::create(['name' => 'Flexibilität - myofacial']);
        TypeTag::create(['name' => 'Koordination - Muskuläre Kontrolle']);
        TypeTag::create(['name' => 'Koordination - Balance']);
        TypeTag::create(['name' => 'Koordination - Technik']);
        TypeTag::create(['name' => 'Koordination - Haltung']);
        TypeTag::create(['name' => 'Ausdauer/Warmin-Up']);
        TypeTag::create(['name' => 'Schnelligkeit']);

        PaceTag::create(['name' => 'Langsam']);
        PaceTag::create(['name' => 'Gleichmäßig']);
        PaceTag::create(['name' => 'Explosiv']);

        AgeTag::create(['name' => '12-17']);
        AgeTag::create(['name' => '18-35']);
        AgeTag::create(['name' => '>35']);

        GenderTag::create(['name' => 'männlich']);
        GenderTag::create(['name' => 'weiblich']);
        GenderTag::create(['name' => 'gemischt']);

        MeasureTag::create(['name' => 'Prävention']);
        MeasureTag::create(['name' => 'Rehabilitation']);

        ObjectiveTag::create(['name' => 'Kraft']);
        ObjectiveTag::create(['name' => 'Flexibilität']);
        ObjectiveTag::create(['name' => 'Balance']);
        ObjectiveTag::create(['name' => 'Warming-Up']);
        ObjectiveTag::create(['name' => 'Exzentrisches Training']);
        ObjectiveTag::create(['name' => 'Neuromuskuläres Training']);
        ObjectiveTag::create(['name' => 'Core Stability']);
        ObjectiveTag::create(['name' => 'Bewegungstechnik']);

        LevelTag::create(['name' => 'Level 1']);
        LevelTag::create(['name' => 'Level 2']);
        LevelTag::create(['name' => 'Level 3']);
        LevelTag::create(['name' => 'Level 4']);
        LevelTag::create(['name' => 'Level 5']);

    }
}
