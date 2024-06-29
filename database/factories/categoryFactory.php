<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\category>
 */
class categoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model=Category::class;

    public function definition(): array
    {
        return [
            //
            'name'=>$this->faker->word,
            'slug'=>$this->faker->word,
        ];
    }
    public function configure():categoryFactory{
        return $this->afterCreating(function(Category $category){
            $category->products()->saveMany(Product::factory(10)->make());
        });
    }
}
