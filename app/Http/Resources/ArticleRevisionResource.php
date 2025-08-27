<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleRevisionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'revision';

    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'body'        => $this->body,
            'slug'        => $this->slug,
            'user'        => $this->user ? [
                'id'       => $this->user->id,
                'username' => $this->user->username,
            ] : null,
            'createdAt'   => $this->created_at,
        ];
    }
}
