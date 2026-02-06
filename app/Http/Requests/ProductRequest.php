<?php

namespace App\Http\Requests;

use App\Helpers\PhoneHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'type' => 'required',
			'category_id' => 'required',
			'name' => 'required',
            // 'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cover' => 'nullable|image',
            // 'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images' => $this->isMethod('post') ? 'required|array' : 'nullable|array',
            'images.*' => $this->isMethod('post') ? 'required|image' : 'nullable|image',
			'size_options' => 'required',
			// 'material_options' => 'required',
			'material_color_options' => 'required',
			'sablon_type' => 'required',
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
        $attributes['name'] = 'Name';
        $attributes['cover'] = 'Cover';
        if ($this->has('images')) {
            foreach ($this->images as $index => $file) {
                $attributes["images.$index"] = "Images " . ($index + 1);
            }
        }

        // return [
        //     'name' => 'Name',
        //     'cover' => 'Cover',
        //     'images' => 'Images',
        // ];

        return $attributes;
    }

    public function messages()
    {
        return [
            'type.required'     => ':attribute harus diisi.',
            'category_id.required'     => ':attribute harus diisi.',
            'name.required'     => ':attribute harus diisi.',
            'cover.image'       => ':attribute harus berupa gambar.',
            'cover.mimes'       => 'Format :attribute harus jpeg, png, jpg.',
            'cover.max'         => 'Ukuran :attribute maksimal gambar 2MB.',
            'images.required'     => ':attribute harus diisi.',
            'images.image'      => ':attribute harus berupa gambar.',
            'size_options.required'     => ':attribute harus diisi.',
            // 'material_options.required'     => ':attribute harus diisi.',
            'material_color_options.required'     => ':attribute harus diisi.',
            'sablon_type.required'     => ':attribute harus diisi.',
            // 'images.mimes'      => 'Format :attribute harus jpeg, png, jpg.',
            // 'images.max'        => 'Ukuran :attribute maksimal gambar 2MB.',
        ];
    }
}
