<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CMSSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'menu_id' => ['required', 'integer'],
            'component_id' => ['required','integer'],
            'columns' => ['integer'],
            'order_id' => ['required','integer'],
        ];
    }
}
