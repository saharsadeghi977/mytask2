<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model=Product::class;
    public function definition(): array
    {

    {

    }
        return [
            //
            'name'=>$this->faker->word,
            'slug'=>$this->faker->word,
            'type'=>$this->faker->word,
            'description'=>$this->faker->paragraph,
            'image'=>$this->faker->imageUrl(),

        ];
    }
}
