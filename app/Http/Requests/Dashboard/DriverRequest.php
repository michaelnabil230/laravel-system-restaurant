<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'phone' => [
                'required',
                'array',
                'min:1'
            ],
            'phone.0' => [
                'required'
            ],
        ];
    }

    private function update()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'phone' => [
                'required',
                'array',
                'min:1'
            ],
            'phone.0' => [
                'required'
            ],
        ];
    }
}
