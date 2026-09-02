<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = fake()->unique()->catchPhrase();

        return [
            'title'        => $title,
            'slug'         => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 99999),
            'summary'      => fake()->sentence(),
            'description'  => fake()->paragraphs(2, true),
            'category'     => fake()->randomElement(['Boilermaking', 'Structural Steel', 'Pressure Vessels', 'Repairs & Maintenance']),
            'materials'    => 'Mild steel, 304 stainless',
            'client'       => fake()->company(),
            'location'     => fake()->city(),
            'completed_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'is_published' => true,
            'is_featured'  => false,
            'sort_order'   => 0,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['is_published' => false]);
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }
}
