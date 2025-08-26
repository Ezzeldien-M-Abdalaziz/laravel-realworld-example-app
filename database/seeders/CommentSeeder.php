<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
	public function run(): void
	{
		$articles = Article::all();

		$articles->each(function (Article $article) {
			Comment::factory()->count(rand(0, 5))->create([
				'article_id' => $article->id,
			]);
		});
	}
}


