<?php

namespace Database\Factories;

use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Workout::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $type = $this->faker->numberBetween(1, 2);

        $holding_period = null;
        $repetitions = null;
        if($type == 1){
            $repetitions = $this->faker->numberBetween(1,20);
        }else{
            $holding_period = $this->faker->numberBetween(30,200);
        }
    
        $equipment_needed = $this->faker->boolean;
        $weight = null;
        if($equipment_needed){
            $weight = $this->faker->numberBetween(1,10);
        }
      
        return [
            //

            'image_path' => 'tempworkout.jpg',
            'type' => $this->faker->numberBetween(1, 2),
            'equipment_needed' => $this->faker->boolean,
            'weight_default' => $weight,
            'repetitions_default' => $repetitions,
            'holding_period_default' => $holding_period,
            'rest_default' => $this->faker->numberBetween(10,60),
            'sets_default' => $this->faker->numberBetween(1,5),
            'video_id' => null,            
        ];
    }
}
