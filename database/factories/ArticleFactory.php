<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    private static $order = 1;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => "Article_" . self::$order++,
            'type' => "type",
            'etat' => "confirm",
            'content' => $this->faker->sentence(),
            'baseArticle' => "1",
            'rank' => "0",
            'score' => "0",
            'vote_up' => "0",
            'vote_down' => "0",
            'user_id' => "1",
        ];
    }
}
