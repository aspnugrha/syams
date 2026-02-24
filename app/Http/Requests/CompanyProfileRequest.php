<?php

namespace App\Http\Requests;

use App\Helpers\PhoneHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyProfileRequest extends FormRequest
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
			'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('company_profiles', 'email')->ignore($id)
            ],
			'phone_number' => [
                'required',
                Rule::unique('company_profiles', 'phone_number')->ignore($id)
            ],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pavicon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_landing_page' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_showcase' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
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
            'name' => 'Name',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'logo' => 'Logo',
            'pavicon' => 'Pavicon',
            'banner_landing_page' => 'Banner Landing Page',
            'banner_showcase' => 'Banner Showcase',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => ':attribute harus diisi.',
            'email.required'    => ':attribute harus diisi.',
            'email.email'       => ':attribute tidak valid.',
            'email.unique'      => ':attribute sudah digunakan.',
            'phone_number.required' => ':attribute harus diisi.',
            'phone_number.unique' => ':attribute sudah digunakan.',
            'logo.image'       => ':attribute harus berupa gambar.',
            'logo.mimes'       => 'Format :attribute harus jpeg, png, jpg.',
            'logo.max'         => 'Ukuran :attribute maksimal gambar 2MB.',
            'pavicon.image'    => ':attribute harus berupa gambar.',
            'pavicon.mimes'    => 'Format :attribute harus jpeg, png, jpg.',
            'pavicon.max'      => 'Ukuran :attribute maksimal gambar 2MB.',
            'banner_landing_page.image'    => ':attribute harus berupa gambar.',
            'banner_landing_page.mimes'    => 'Format :attribute harus jpeg, png, jpg.',
            'banner_landing_page.max'      => 'Ukuran :attribute maksimal gambar 2MB.',
            'banner_showcase.image'    => ':attribute harus berupa gambar.',
            'banner_showcase.mimes'    => 'Format :attribute harus jpeg, png, jpg.',
            'banner_showcase.max'      => 'Ukuran :attribute maksimal gambar 2MB.',
        ];
    }
}
