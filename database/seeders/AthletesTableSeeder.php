<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Athlete;
use App\Models\Office;
use App\Models\HealthRecord;
use App\Models\User;
use App\Models\HealthRecordEntry;
use Illuminate\Support\Facades\Hash;

class AthletesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $password = Hash::make('juckel2');

        Office::all()->each(function ($office) use ($password) {
            Athlete::factory()->count(mt_rand(20, 50))->make([
                'password' => $password
            ])->each(function ($athlete) use ($office) {
                $athlete->office()->associate($office)->save();

                $healthRecord = new HealthRecord();
                $healthRecord->athlete()->associate($athlete)->save();

                $officeUsers = User::whereOfficeId($office->id)
                    ->with('role')
                    ->get();

                $officeTherapist = $officeUsers
                    ->where('role.name', 'therapist')
                    ->first();

                if (!$officeTherapist) {
                    return;
                }

                HealthRecordEntry::factory()->count(2)
                    ->make()
                    ->each(function ($entry) use ($healthRecord, $officeTherapist) {
                        $entry->healthRecord()->associate($healthRecord);
                        $entry->user()->associate($officeTherapist)->save();
                    });
            });
        });

        $testAthlete = Athlete::factory()->make([
            'email' => 'patient@utsdev.de',
            'password' => $password,
            'language_code' => 'de',
        ]);

        $testAthlete->office()->associate(Office::all()->shift())->save();

        $testHealthRecord = new HealthRecord();
        $testHealthRecord->athlete()->associate($testAthlete)->save();
    }
}
