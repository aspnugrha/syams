<?php

namespace App\Http\Requests;

use App\Helpers\PhoneHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileCustomerRequest extends FormRequest
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
                Rule::unique('customers', 'email')->ignore($id)
            ],
			'phone_number' => [
                'required',
                Rule::unique('customers', 'phone_number')->ignore($id)
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
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
            'image' => 'Profile',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required'     => 'Enter :attribute.',
            'email.required'    => 'Enter :attribute.',
            'email.email'       => ':attribute not valid.',
            'email.unique'      => ':attribute already used.',
            'phone_number.required' => 'Enter :attribute.',
            'phone_number.unique' => ':attribute already used.',
            'image.image'       => ':attribute must be an image.',
            'image.mimes'       => 'Format :attribute must be jpeg, png, jpg.',
            'image.max'         => 'Maximum :attribute image size 2MB.',
        ];
    }
}
