<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'titulo' => 'required',
            'descricao' => 'required',
            'category_id' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg'
        ];
    }

    public function messages()
    {
    	return [
    		'required' => 'Este campo é obrigatório',
		    'image'    => 'Arquivo não é uma imagem válida!'
	    ];
    }
}
