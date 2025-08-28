<?php

namespace Database\Factories;

use App\Models\ArticleRevision;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleRevisionFactory extends Factory
{
    protected $model = ArticleRevision::class;

    public function definition(): array
    {
        return [
            'article_id'  => Article::factory(),
            'user_id'     => User::factory(),
            'title'       => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'body'        => $this->faker->text,
            'slug'        => $this->faker->slug,
        ];
    }
}
