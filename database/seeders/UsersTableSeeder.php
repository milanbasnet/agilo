<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;
use App\Models\Role;
use App\Models\TherapistRole;
use App\Models\User;
use App\Models\AdminOffice;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $offices = Office::all();
        $defaultOffice = $offices->shift();
        $testOffice = $offices->shift();
        $roles = Role::all();
        $userTherapistRole =TherapistRole::all()->first();

        $adminRole = $roles->where('name','admin')->first();
        // $adminRole = $roles->first(function ($key, $value) {
        //     return $value->name == 'admin';
        // });
        $officeAdminRole = $roles->where('name','office-admin')->first();

        // $officeAdminRole = $roles->first(function ($key, $value) {
        //     return $value->name == 'office-admin';
        // });
        $therapistRole = $roles->where('name','therapist')->first();

        // $therapistRole = $roles->first(function ($key, $value) {
        //     return $value->name == 'therapist';
        // });

        $offices->each(function ($office) use ($officeAdminRole, $therapistRole, $userTherapistRole) {
            $officeAdmin = User::factory()->make();
            $this->addAssociationsAndSave($officeAdmin, $office, $officeAdminRole);

            User::factory()->count(mt_rand(2, 5))->make()->each(function ($user) use ($office, $therapistRole, $userTherapistRole) {
                $this->addAssociationsAndSave($user, $office, $therapistRole, $userTherapistRole);
            });
        });

        $admin = User::factory()->make([
            'email' => 'admin@utsdev.de',
            'password' => Hash::make('juckel2'),
            'language_code' => 'de',
        ]);

        $this->addAssociationsAndSave($admin, $defaultOffice, $adminRole);

        $adminOffice = new AdminOffice();
        $adminOffice->office()->associate($defaultOffice)->save();

        $testOfficeAdmin = User::factory()->make([
            'email' => 'oa@utsdev.de',
            'password' => Hash::make('juckel2'),
            'language_code' => 'de',
        ]);

        $this->addAssociationsAndSave($testOfficeAdmin, $testOffice, $officeAdminRole);

        $testTherapist = User::factory()->make([
            'email' => 't@utsdev.de',
            'password' => Hash::make('juckel2'),
            'language_code' => 'de',
        ]);

        $this->addAssociationsAndSave($testTherapist, $testOffice, $therapistRole, $userTherapistRole);

        User::factory()->count(9)->make()->each(function ($user) use ($testOffice, $therapistRole, $userTherapistRole) {
            $this->addAssociationsAndSave($user, $testOffice, $therapistRole, $userTherapistRole);
        });
    }

    private function addAssociationsAndSave($user, $office, $role, $userTherapistRole = false)
    {
        $user->office()->associate($office)
            ->role()->associate($role);

        if ($userTherapistRole) {
            $user->therapistRole()->associate($userTherapistRole);
        }

        $user->save();
    }
}
