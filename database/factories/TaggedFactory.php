<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaggedFactory extends Factory
{
    private static $order = 1;
    private static $orderCategory = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if(self::$order % 20 == 0){
            self::$orderCategory++;
        }
        return [
            'category_id' => self::$orderCategory,
            'article_id' => self::$order++,
            'score' => 0,
        ];
    }
}
