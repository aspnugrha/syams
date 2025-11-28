<?php

namespace App\Http\Requests;

use App\Helpers\PhoneHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PasswordCustomerRequest extends FormRequest
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
			'id' => 'required',
			'old_password' => 'required|min:6',
			'new_password' => 'required|min:6',
			'confirm_new_password' => 'required|min:6|same:new_password',
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
            'old_password' => 'Old password',
            'new_password' => 'New password',
            'confirm_new_password' => 'Password Confirmation',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required'     => 'Enter :attribute.',
            'old_password.min'     => ':attribute minimum 6 characters.',
            'new_password.required'     => 'Enter :attribute.',
            'new_password.min'     => ':attribute minimum 6 characters.',
            'confirm_new_password.required'     => 'Enter :attribute.',
            'confirm_new_password.min'     => ':attribute minimum 6 characters.',
            'confirm_new_password.same'     => ':attribute must be the same as the new password.',
        ];
    }
}
