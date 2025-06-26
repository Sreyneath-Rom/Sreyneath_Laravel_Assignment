<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Custom failed validation response
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422)
        );
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:2|max:255',
            'author_id' => 'sometimes|required|exists:authors,id',
            'isbn' => 'sometimes|required|string|unique:books,isbn',
            'published_year' => 'sometimes|required|integer',
            'genre' => 'sometimes|required|string',
            'summary' => 'sometimes|required|string',
        ];
    }
}