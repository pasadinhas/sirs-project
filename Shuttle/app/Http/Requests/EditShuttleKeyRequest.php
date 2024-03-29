<?php

namespace Shuttle\Http\Requests;

use Shuttle\Http\Requests\Request;

class EditShuttleKeyRequest extends Request
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
            'key' => 'required|alpha_num|size:32',
        ];
    }
}
