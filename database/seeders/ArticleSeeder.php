<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
	public function run(): void
	{
		$tags = Tag::all();
        $users = User::all();
		Article::factory()
			->count(30)
			->create()
			->each(function (Article $article) use ($tags) {
				$article->tags()->sync($tags->random(rand(1, min(3, max(1, $tags->count()))))->pluck('id')->toArray());

			})
            ->each(function (Article $article) use ($users) {
                $article->users()->except($article->user)->sync($users->random(rand(1, min(3, max(1, $users->count()))))->pluck('id')->toArray());
            });
	}
}


