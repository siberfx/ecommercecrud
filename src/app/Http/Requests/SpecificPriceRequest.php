<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;

class SpecificPriceRequest extends CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		// only allow updates if the user is logged in
		return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reduction'         => 'required|numeric',
            'start_date'        => 'required|date|before:expiration_date',
            'expiration_date'   => 'required|date|after:start_date',
            'product_id'        => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'start_date.before'    => 'The start date should be before to end date',
            'expiration_date.after' => 'The expiration date should be after start date'
        ];
    }
}
