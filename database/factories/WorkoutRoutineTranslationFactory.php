<?php

namespace Database\Factories;

use App\Models\WorkoutRoutineTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutRoutineTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkoutRoutineTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'language_code' => $this->faker->languageCode,
            'title_internal' => $this->faker->sentence,
            'title_external' => $this->faker->sentence,
            'description_internal' => $this->faker->paragraph,
            'description_external' => $this->faker->paragraph,
        ];
    }
}
