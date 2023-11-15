<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    protected function failedValidation(Validator $validator)
    {
        //  if ($this->ajax() or $this->routeIs('api/*'))
        if ($this->ajax())
            throw new HttpResponseException(
                response()->json([
                    'message' => 'validation Error',
                    'data' => implode(',', $validator->errors()->all())
                ])
            );
        else {
            throw new HttpResponseException(
                back()->withErrors($validator->errors()->all())
            );
        }
    }
}
