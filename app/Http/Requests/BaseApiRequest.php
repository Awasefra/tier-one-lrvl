<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // default API allow
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'meta' => [
                    'success' => false,
                    'message' => 'Validation failed',
                ],
                'errors' => $validator->errors(),
                'data' => null,
            ], 422)
        );
    }
}
