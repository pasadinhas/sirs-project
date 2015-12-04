<?php

namespace Shuttle\Http\Requests;

use Shuttle\Http\Requests\Request;

class CreateShuttleRequest extends Request
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
            'name' => 'required',
            'seats' => 'required|integer',
            'key' => 'required|alpha_num|size:32',
        ];
    }
}
