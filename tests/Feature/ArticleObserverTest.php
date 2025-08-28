<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleObserverTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_a_revision_when_article_is_updated()
    {
        $user = User::factory()->create();

        $article = Article::factory()->create([
            'user_id' => $user->id,
            'title' => 'Original Title',
            'description' => 'Original Description',
            'body' => 'Original Body',
            'slug' => 'original-slug',
        ]);

        $this->actingAs($user);

        // Update the article → should trigger observer
        $article->update([
            'title' => 'Updated Title',
            'body' => 'Updated Body',
        ]);

        // Assert the old values got stored in revisions
        $this->assertDatabaseHas('article_revisions', [
            'article_id'  => $article->id,
            'title'       => 'Original Title',
            'body'        => 'Original Body',
        ]);
    }
}
