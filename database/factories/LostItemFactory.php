<?php

namespace Database\Factories;

use App\Models\LostItem;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class LostItemFactory extends Factory
{
    protected $model = LostItem::class;

    public function definition()
    {
        return [
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'location' => $this->faker->address,
            'contact_info' => $this->faker->phoneNumber,
            'image_path' => $this->faker->imageUrl,
        ];
    }
}
