<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fakerEn = \Faker\Factory::create('en_US');
        $fakerAr= \Faker\Factory::create('ar_SA');
        return [
            'ar' => [
                'name' => $fakerAr->name,
                'description' => $fakerAr->paragraph,
            ],
            'en' => [
                'name' => $fakerEn->name,
                'description' => $fakerEn->paragraph,
            ],

            'purchase_price' => $this->faker->numberBetween(50,1000),
            'sale_price' => $this->faker->numberBetween(1100,3000),
            'stock'=> $this->faker->numberBetween(1,100),
            'image' => $this->faker->image(public_path().'/uploads/product_images/',200,200, 'business', false),
            'category_id' => $this->faker->numberBetween(1,5),

        ];
    }
}
