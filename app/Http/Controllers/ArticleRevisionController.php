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
        $this->authorize('view', $article);

        return new ArticleRevisionCollection($article->revisions()->latest()->get());
    }

    public function show(Article $article, ArticleRevision $revision): ArticleRevisionResource
    {
        $this->authorize('view', $article);

        return new ArticleRevisionResource($revision);
    }

    public function revert(Article $article, ArticleRevision $revision): ArticleRevisionResource
    {
        $this->authorize('revert', $article);

        $article->update([
            'title'       => $revision->title,
            'description' => $revision->description,
            'slug'        => $revision->slug,
            'body'        => $revision->body,
        ]);

        return new ArticleRevisionResource($revision);
    }
}
