<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

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
            'ar'=>
        ['name' => $fakerAr->company],
            'en' =>
                ['name' => $fakerEn->company],
        ];
    }
}
