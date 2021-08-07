<?php
namespace Database\Seeders;

use App\Models\OfficeType;
use Illuminate\Database\Seeder;

class OfficeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        OfficeType::create(['i18n' => 'db.office.type.club']);
        OfficeType::create(['i18n' => 'db.office.type.office']);
    }
}
