<?php

namespace Database\Factories;

use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfficeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Office::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->company,
            'street' => $this->faker->streetAddress,
            'zip_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->companyEmail,
            'logo_path' => 'tempworkout.jpg',
            'has_billing_address' => true,
            'billing_name' => $this->faker->company,
            'billing_street' => $this->faker->streetAddress,
            'billing_zip_code' => $this->faker->postcode,
            'billing_city' => $this->faker->city,
            'billing_country' => $this->faker->country,
            'contact' => $this->faker->firstName . ' ' . $this->faker->lastName,
        ];
    }
}
