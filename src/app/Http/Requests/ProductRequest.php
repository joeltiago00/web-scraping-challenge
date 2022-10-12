<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $name_controller = $this->route()->action['controller'];

        if (str_contains($name_controller, '@index'))
            return $this->validationIndex();
    }

    /**
     * @return string[]
     */
    public function validationIndex(): array
    {
        return [
            'pp' => 'required|numeric|min:1|max:15',
            'pg' => 'required|numeric|min:1'
        ];
    }
}
