<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrontendUserProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (env('CAS_ENABLED')) {
            if (cas()->authenticate()) {
                return true;
            }
            else {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        #if cast to bool in:1 checkbox rule
        return [
            'rodoConsent' => 'accepted',
            'avatar' => ['mimes: jpeg,png,jpg','max:2048'],
            'token' => ['required','string','min:16','max:16']
        ];
    }

    public function messages()
    {
        return [
            'rodoConsent' => 'Musisz wyrazić zgodę aby brać aktywny udział w serwisie',
            'avatar' => 'Zdjęcie profilowe jest niepoprawne. Dopuszczalne formaty to jpeg, png, jpg o maksymalnym rozmiarze 2Mb',
            'token' => 'Nieprawidłowy token'
        ];
    }
}
