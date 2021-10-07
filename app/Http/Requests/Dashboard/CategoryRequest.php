<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'position' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647'
            ],
        ];
        foreach (config('config_me.locales') as $locale) {
            $rules += [
                'name.' . $locale => [
                    'required',
                    Rule::unique('categories', 'name->' . $locale)
                ],
            ];
        } //end of for each
        return $rules;
    }

    private function update()
    {
        $rules = [
            'position' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647'
            ],
        ];
        foreach (config('config_me.locales') as $locale) {
            $rules += [
                'name.' . $locale => [
                    'required',
                    Rule::unique('categories', 'name->' . $locale)->ignore($this->category->id, 'id')
                ],
            ];
        } //end of for each

        return $rules;
    }
}
