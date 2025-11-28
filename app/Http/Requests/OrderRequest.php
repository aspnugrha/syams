<?php

namespace App\Http\Requests;

use App\Helpers\PhoneHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('phone_number')) {
            $this->merge([
                'phone_number' => PhoneHelper::normalize_phone($this->phone_number),
            ]);
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->id;
        return [
			'fullname' => 'required',
            'email' => [
                'required',
                'email',
            ],
			'phone_number' => [
                'required',
            ],
            'order_type' => 'required',
            'products_id' => 'required',
            // 'size_options' => 'required_if:order_type,order',
            // 'qty_options' => 'required_if:order_type,order',
        ];
    }

    public function store(MasterUserRequest $request)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...
        $validated = $request->validated();
    }

    public function attributes()
    {
        return [
            'fullname' => 'Fullname',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'order_type' => 'Order Type',
            'products_id' => 'Product',
            // 'size_options' => 'Size Option',
            // 'qty_options' => 'Quantity Option',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required'     => 'please enter :attribute.',
            'email.required'    => 'please enter :attribute.',
            'email.email'       => 'invalid :attribute.',
            'phone_number.required' => 'please enter :attribute.',
            'order_type.required'    => 'please enter :attribute.',
            'products_id.required'    => 'Select one :attribute.',
            // 'size_options.required_id'    => ':attribute harus diisi.',
            // 'qty_options.required_id'    => ':attribute harus diisi.',
        ];
    }
}
