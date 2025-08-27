<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleRevisionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public static $wrap = 'revisions';

    public function toArray($request): array
    {
        return $this->collection->map(fn ($revision) => new ArticleRevisionResource($revision))->all();
    }
}
