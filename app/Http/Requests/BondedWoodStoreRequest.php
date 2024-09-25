<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BondedWoodStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (request()->isMethod('POST')){
            return [
                'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            ];
        } else {
            return [
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            ];
        }
    }
}
