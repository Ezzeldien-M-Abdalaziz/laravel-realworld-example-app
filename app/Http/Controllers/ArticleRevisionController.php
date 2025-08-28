<?php
namespace App\Http\Controllers;

use App\Http\Resources\ArticleRevisionCollection;
use App\Http\Resources\ArticleRevisionResource;
use App\Models\Article;
use App\Models\ArticleRevision;
use Illuminate\Support\Facades\Auth;

class ArticleRevisionController extends Controller
{
    public function index(Article $article): ArticleRevisionCollection
    {
        $this->authorize('viewRevisions', $article);

        return new ArticleRevisionCollection($article->revisions()->latest()->get());
    }

    public function show(Article $article, ArticleRevision $revision): ArticleRevisionResource
    {
        $this->authorize('viewRevisions', $article);

        abort_if($revision->article_id !== $article->id, 404);
        return new ArticleRevisionResource($revision->load('user'));
    }

    public function revert(Article $article, ArticleRevision $revision): ArticleRevisionResource
    {
        $this->authorize('revert', $article);

        abort_if($revision->article_id !== $article->id, 404);

        $article->update([
            'title'       => $revision->title,
            'description' => $revision->description,
            'body'        => $revision->body,
        ]);

        return new ArticleRevisionResource($revision->load('user'));
    }
}
