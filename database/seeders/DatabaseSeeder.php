<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        // DB::table('offices')->delete();
        // DB::table('office_types')->delete();
        // DB::table('videos')->delete();
        // DB::table('roles')->delete();
        // DB::table('therapist_roles')->delete();
        // DB::table('users')->delete();
        // DB::table('workouts')->delete();
        // DB::table('workout_translations')->delete();
        // DB::table('athletes')->delete();
        // DB::table('health_records')->delete();
        // DB::table('health_record_entries')->delete();
        // DB::table('athlete_group_levels')->delete();
        // DB::table('athlete_group_sports')->delete();
        // DB::table('athlete_groups')->delete();
        // DB::table('workout_routines')->delete();
        // DB::table('workout_routine_translations')->delete();
        // DB::table('parameterized_workouts')->delete();
        // DB::table('equipments')->delete();
        // DB::table('region_tags')->delete();
        // DB::table('pace_tags')->delete();
        // DB::table('gender_tags')->delete();
        // DB::table('level_tags')->delete();
        // DB::table('type_tags')->delete();
        // DB::table('objective_tags')->delete();
        // DB::table('measure_tags')->delete();
//        DB::table('timed_workout_routines')->delete();

        $this->call('Database\Seeders\TagsTableSeeder');
        $this->call('Database\Seeders\EquipmentsTableSeeder');
        $this->call('Database\Seeders\OfficeTypesTableSeeder');
        $this->call('Database\Seeders\OfficesTableSeeder');
        $this->call('Database\Seeders\VideosTableSeeder');
        $this->call('Database\Seeders\RolesTableSeeder');
        $this->call('Database\Seeders\TherapistRolesTableSeeder');
        $this->call('Database\Seeders\UsersTableSeeder');
        $this->call('Database\Seeders\WorkoutsTableSeeder');
        $this->call('Database\Seeders\WorkoutTranslationsTableSeeder');
        //$this->call('WorkoutRoutinesTableSeeder');
        //$this->call('WorkoutRoutineTranslationsTableSeeder');
//        $this->call('ParameterizedWorkoutsTableSeeder');
        $this->call('Database\Seeders\AthletesTableSeeder');
        $this->call('Database\Seeders\AthleteGroupLevelsTableSeeder');
        $this->call('Database\Seeders\AthleteGroupSportsTableSeeder');
        $this->call('Database\Seeders\AthleteGroupsTableSeeder');
        $this->call('Database\Seeders\AthletesRelationSeeder');
//        $this->call('TimedWorkoutRoutinesSeeder');

        Model::reguard();
    }
}
