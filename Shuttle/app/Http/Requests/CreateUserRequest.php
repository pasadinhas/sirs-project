<?php

namespace Shuttle\Http\Requests;

use Shuttle\Http\Requests\Request;

class CreateUserRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|min:3|alpha_dash',
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|email',
            'id_document' => 'required|alpha_num',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }
}
