<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tag' => 'sometimes|string',
            'author' => 'sometimes|string',
            'favorited' => 'sometimes|string',
            'limit' => 'sometimes|integer',
            'offset' => 'sometimes|integer'
        ];
    }

    public function messages()
    {
        return [
            'tag.string' => 'The tag field must be a string.',
            'author.string' => 'The author field must be a string.',
            'favorited.string' => 'The favorited field must be a string.',
            'limit.integer' => 'The limit field must be an integer.',
            'offset.integer' => 'The offset field must be an integer.',
        ];
    }
}
