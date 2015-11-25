<?php

namespace Shuttle\Http\Requests;

use Shuttle\Http\Requests\Request;

class CreateTripRequest extends Request
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
            'shuttle_id' => 'required',
            'driver_id' => 'required',
            'origin' => 'required',
            'destination' => 'required',
            'leaves_at' => 'required',
            'arrives_at' => 'required',
        ];
    }
}
