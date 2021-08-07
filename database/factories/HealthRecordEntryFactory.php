<?php

namespace Database\Factories;

use App\Models\HealthRecordEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

class HealthRecordEntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HealthRecordEntry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->paragraph,
        ];
    }
}
