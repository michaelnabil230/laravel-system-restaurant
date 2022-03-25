<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductRequest extends FormRequest
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
        return request()->isMethod('post') ? $this->store() : $this->update();
    }

    private function store()
    {
        $rules = [
            'category_id' => [
                'required',
                'exists:categories,id'
            ],
            'image' => [
                'required',
                'image'
            ],
            'price' => [
                'required'
            ],
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $locale) {
            $rules += [
                'name.' . $locale => [
                    'required',
                    Rule::unique('products', 'name->' . $locale)
                ],
            ];
        }

        return $rules;
    }

    private function update()
    {
        $rules = [
            'category_id' => [
                'required',
                'exists:categories,id'
            ],
            'image' => [
                'required',
                'image'
            ],
            'price' => [
                'required'
            ],
        ];
        foreach (LaravelLocalization::getSupportedLocales() as $locale) {
            $rules += [
                'name.' . $locale => [
                    'required',
                    Rule::unique('products', 'name->' . $locale)->ignore($this->product->id, 'product_id')
                ],
            ];
        }

        return $rules;
    }
}
