<?php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'office-admin']);
        Role::create(['name' => 'therapist']);
        Role::create(['name' => 'trial']);
    }
}
