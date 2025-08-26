<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
	public function run(): void
	{
		$tags = Tag::all();

		Article::factory()
			->count(30)
			->create()
			->each(function (Article $article) use ($tags) {
				$article->tags()->sync($tags->random(rand(1, min(3, max(1, $tags->count()))))->pluck('id')->toArray());
			});
	}
}


