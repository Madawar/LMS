<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'staff' => $this->faker->name,
            'pno' => $this->faker->numberBetween(1, 123456),
            'department' => $this->faker->numberBetween(1, 4),
            'leave_days' => $this->faker->numberBetween(0, 20),
            'dateOfEmployment' => $this->faker->dateTimeBetween('-2 years', '-4 months'),
            'leaveIncrements' => '1.75'
        ];
    }
}
