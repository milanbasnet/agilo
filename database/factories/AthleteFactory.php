<?php

namespace Database\Factories;

use App\Models\Athlete;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class AthleteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Athlete::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth' => $this->faker->date(),
            'email' => $this->faker->unique()->email,
            'sex' => $this->faker->numberBetween(1,2),
            'password' => Str::random(10),
            'remember_token' => Str::random(10),
            'language_code' => 'de',
        ];
    }
}
