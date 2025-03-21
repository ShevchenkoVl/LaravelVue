<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page' => 'nullable|integer'
        ];
    }

    protected function passedValidation()
    {
        return $this->merge([
            'page' => $this->page ?? 1
        ]);
    }
}
