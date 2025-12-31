<?php

namespace App\Http\Requests;

use App\Helpers\PhoneHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthRegisterRequest extends FormRequest
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
        // if ($this->has('phone_number')) {
        //     $this->merge([
        //         'phone_number' => PhoneHelper::normalize_phone($this->phone_number),
        //     ]);
        // }
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
			'name' => 'required',
            'email' => [
                'required',
                'email',
                // 'unique:customers,email',
                Rule::unique('customers', 'email')->ignore($id)
            ],
            'dial_code' => 'required',
            'country_code' => 'required',
            'dial_code' => 'required',
			'phone_number' => [
                'required',
                // 'unique:customers,phone_number'
                Rule::unique('customers', 'phone_number')->ignore($id)
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'password' => 'required|min:6',
        ];
    }

    public function store(AuthRegisterRequest $request)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...
        $validated = $request->validated();
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'dial_code' => 'Dial Code',
            'country_code' => 'Country Code',
            'phone_number' => 'Phone Number',
            'image' => 'Profile',
            'password' => 'Password',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Enter :attribute.',
            'email.required'    => 'Enter :attribute.',
            'email.email'       => ':attribute not valid.',
            'email.unique'      => ':attribute already used.',
            'phone_number.required' => 'Enter :attribute.',
            'phone_number.unique' => ':attribute already used.',
            'image.image'       => ':attribute harus berupa gambar.',
            'image.mimes'       => 'Format :attribute must be jpeg, png, jpg.',
            'image.max'         => 'Maximum :attribute image size 2MB.',
            'password.required' => 'Enter :attribute.',
            'password.min'      => ':attribute minimum 6 characters.',
        ];
    }
}
