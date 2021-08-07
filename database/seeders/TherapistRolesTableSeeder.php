<?php
namespace Database\Seeders;

use App\Models\TherapistRole;
use Illuminate\Database\Seeder;

class TherapistRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        TherapistRole::create(['i18n' => 'db.therapist.role.coach']);
        TherapistRole::create(['i18n' => 'db.therapist.role.physio']);
        TherapistRole::create(['i18n' => 'db.therapist.role.doctor']);
        TherapistRole::create(['i18n' => 'db.therapist.role.athletic.trainer']);
    }
}
