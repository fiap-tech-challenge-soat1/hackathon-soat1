<?php

namespace Modules\Timekeeping\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Timekeeping\Entities\TimeEntry;
use Modules\User\Entities\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Timekeeping\Entities\TimeEntry>
 */
class TimeEntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = TimeEntry::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'started_at' => $this->faker->dateTimeBetween('-1 hour', 'now'),
        ];
    }
}
