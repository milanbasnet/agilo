<?php

namespace Database\Factories;

use App\Models\WorkoutTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkoutTranslation::class;

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
            'title' => $this->faker->sentence,
            'starting_position' => $this->faker->sentence(3),
            'execution' => $this->faker->sentence,
            'hints' => $this->faker->sentence,
            'difficulty' => $this->faker->sentence(1),
            'title_in_app'=>$this->faker->sentence,
        ];
    }
}
