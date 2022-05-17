<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    private static $order = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if(self::$order == 1){
            return [
                'name' => "Category_" . self::$order++,
                'type' => "Classement",
                'category_id' => "0",
                'user_id' => "1",
                'base_article_id' => "1",
            ];
        }
        else if(self::$order <= 10){
            return [
                'name' => "Category_" . self::$order++,
                'type' => "Classement",
                'category_id' => "1",
                'user_id' => "1",
                'base_article_id' => "1",
            ];
        }
        else {
            return [
                'name' => "Category_" . self::$order++,
                'type' => "Classement",
                'category_id' => "2",
                'user_id' => "1",
                'base_article_id' => "1",
            ];
        }

    }
}
