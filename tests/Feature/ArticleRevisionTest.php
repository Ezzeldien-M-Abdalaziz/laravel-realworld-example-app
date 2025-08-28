<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleRevisionTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_lists_all_revisions_of_an_article()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        ArticleRevision::factory()->count(2)->create([
            'article_id' => $article->id,
            'user_id'    => $user->id,
        ]);

        $this->actingAs($user)
            ->getJson("/api/articles/{$article->id}/revisions")
            ->assertOk()
            ->assertJsonCount(2, 'revisions');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shows_a_single_revision()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $revision = ArticleRevision::factory()->create([
            'article_id' => $article->id,
            'user_id'    => $user->id,
            'title'      => 'Old Title',
        ]);

        $this->actingAs($user)
            ->getJson("/api/articles/{$article->id}/revisions/{$revision->id}")
            ->assertOk()
            ->assertJsonPath('revision.title', 'Old Title');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_reverts_an_article_to_a_previous_revision()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create([
            'user_id' => $user->id,
            'title'   => 'Current Title',
        ]);

        $revision = ArticleRevision::factory()->create([
            'article_id' => $article->id,
            'user_id'    => $user->id,
            'title'      => 'Old Title',
        ]);

        $this->actingAs($user)
            ->postJson("/api/articles/{$article->id}/revisions/{$revision->id}/revert")
            ->assertOk()
            ->assertJsonPath('revision.title', 'Old Title');

        // Article should now be reverted
        $this->assertDatabaseHas('articles', [
            'id'    => $article->id,
            'title' => 'Old Title',
        ]);
    }

#[\PHPUnit\Framework\Attributes\Test]
    public function unauthorized_users_cannot_access_revisions()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $article = Article::factory()->create(['user_id' => $owner->id]);

        $revision = ArticleRevision::factory()->create([
            'article_id' => $article->id,
            'user_id'    => $owner->id,
        ]);

        $this->actingAs($otherUser)
            ->getJson("/api/articles/{$article->id}/revisions/{$revision->id}")
            ->assertForbidden();
    }
}
