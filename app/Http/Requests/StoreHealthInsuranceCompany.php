<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHealthInsuranceCompany extends FormRequest
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
        return [
            'nome' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=150,height=150',
        ];
    }
    
    public function messages()
    {
        return [
            'image.dimensions' => 'A imagem do logo deve ter 150 x 150px',
        ];
    }
}
