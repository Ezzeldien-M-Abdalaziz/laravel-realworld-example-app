<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'article.title' => 'sometimes|string|max:255',
            'article.description' => 'sometimes|string|max:255',
            'article.body' => 'sometimes|string|max:2048',
            'article.tagList' => 'sometimes|array',
            'article.tagList.*' => 'sometimes|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'article.title.string' => 'The title field must be a string.',
            'article.title.max' => 'The title field must not be greater than 255 characters.',
            'article.description.string' => 'The description field must be a string.',
            'article.description.max' => 'The description field must not be greater than 255 characters.',
            'article.body.string' => 'The body field must be a string.',
            'article.body.max' => 'The body field must not be greater than 2048 characters.',
        ];
    }
}
