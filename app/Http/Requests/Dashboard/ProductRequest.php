<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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

        foreach (config('config_me.locales') as $locale) {
            $rules += [
                'name.' . $locale => [
                    'required',
                    Rule::unique('products', 'name->' . $locale)
                ],
            ];
        } //end of for each

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
        foreach (config('config_me.locales') as $locale) {
            $rules += [
                'name.' . $locale => [
                    'required',
                    Rule::unique('products', 'name->' . $locale)->ignore($this->product->id, 'product_id')
                ],
            ];
        } //end of for each

        return $rules;
    }
}
