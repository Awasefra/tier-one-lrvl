<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;

class CustomerStoreRequest extends BaseApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:30'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {

            if ($this->phone && $this->isDuplicatePhone($this->phone)) {
                $validator->errors()->add(
                    'phone',
                    'Phone number already exists'
                );
            }
        });
    }

    protected function isDuplicatePhone(string $phone): bool
    {
        return \App\Models\Customer::where('phone', $phone)->exists();
    }
}
