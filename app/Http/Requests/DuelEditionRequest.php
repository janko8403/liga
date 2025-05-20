<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DuelEditionRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'category' => ['required', 'string'],
            'active_from' => ['required','date'],
            'active_to' => ['required','date','after:active_from'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Proszę podaj nazwę edycji pojedynku',
            'category.required' => 'Proszę podaj nazwę kategorii pojedynku',
            'active_from.required' => 'Data początkowa jest wymagana',
            'active_to.required' => 'Data końcowa aktywności jest wymagana',
            'active_to.after' => 'Data końcowa nie może być wcześniejsza niż początkowa',
        ];
    }
}
