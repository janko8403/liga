<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'password'=> [
                'string',
                Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Podaj imię i nazwisko',
            'email.email' => 'Podaj prawidłowy adres email',
            'email.required' => 'Adres email jest wymagany',
            'email.unique' => 'Adres email jest już używany.',
            'permissions.required' => 'Wybierz poziom uprawnień administratora',
            'password' => 'Hasło powinno mieć minimum 8 znaków, cyfry, litery i duże litery',
        ];
    }
}
