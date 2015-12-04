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
            'shuttle_id' => 'required|integer',
            'driver_id' => 'required|integer',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'leaves_at' => 'required|date',
            'arrives_at' => 'required|date',
        ];
    }
}
