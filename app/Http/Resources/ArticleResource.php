<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ArticleResource extends JsonResource
{
    public static $wrap = 'article';

    public function toArray($request): array
    {
        $favorited = false;
        $following = false;

        if (Auth::user()) {
            $favorited = $this->users->contains(Auth::user()->id);
            $following = $this->user->followers->contains(Auth::user()->id);
        }

        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'body' => $this->body,
            'tagList' => $this->tags->pluck('name'),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'favoritesCount' => (int) $this->users_count,
            'favorited' => $favorited,
            'author' => [
                'username' => $this->user->username,
                'bio' => $this->user->bio,
                'image' => $this->user->image,
                'following' => $following
            ]
        ];
    }
}
