<?php

namespace MicahDShackelford\RmapLaravel\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use MicahDShackelford\RmapLaravel\Models\Relationship;

class ModelFactory extends Factory
{
    protected $model = Relationship::class;

    public function definition()
    {
        return [
            'origin_table' => $this->faker->word(),
            'origin_column' => $this->faker->word(),
            'target_connection' => $this->faker->word(),
            'target_schema' => $this->faker->word(),
            'target_table' => $this->faker->word(),
            'target_column' => $this->faker->word(),
        ];
    }
}
