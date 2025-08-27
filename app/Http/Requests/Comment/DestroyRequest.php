<?php

namespace App\Http\Requests\Comment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('comment')->user->id === Auth::user()->id;
    }

    public function rules(): array
    {
        return [];
    }
}
s
