<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCardTransfersRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'card_no'=> ['required'],
            'to_card_no' => ['required'],
            'record' => ['nullable'],
            'amount'=> ['required'],
            'exchange'=> ['required'],
        ];
    }
}
