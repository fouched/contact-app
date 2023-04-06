<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->sentence(),
            'description' => fake()->text(),
            'user_id' => User::pluck('id')->random()
        ];
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => true
            ];
        });
    }

    public function uncompleted()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => false
            ];
        });
    }

    // below uses an anonymous function that also
    // exposes the method arg to the function
    public function priority($level = 1)
    {
        return $this->state(fn (array $attributes) => [
                'priority' => $level
            ]
        );
    }
}
