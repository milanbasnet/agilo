<?php

namespace Database\Factories;

use App\Models\AthleteGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class AthleteGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AthleteGroup::class;

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
            'description' => $this->faker->sentence,
            'workouts_per_week' => 3,
        ];
    }
}
