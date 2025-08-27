<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'article.title' => 'required|string|max:255',
            'article.description' => 'required|string|max:255',
            'article.body' => 'required|string|max:2048',
            'article.tagList' => 'sometimes|array',
            'article.tagList.*' => 'sometimes|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'article.title.required' => 'The title field is required.',
            'article.title.string' => 'The title field must be a string.',
            'article.title.max' => 'The title field must not be greater than 255 characters.',
            'article.description.required' => 'The description field is required.',
            'article.description.string' => 'The description field must be a string.',
            'article.description.max' => 'The description field must not be greater than 255 characters.',
            'article.body.required' => 'The body field is required.',
            'article.body.string' => 'The body field must be a string.',
            'article.body.max' => 'The body field must not be greater than 2048 characters.',
        ];
    }
}
