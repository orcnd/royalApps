<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class newBookRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'=>'string|required',
            'author_id'=>'string|required',
            'description'=>'string|required',
            'release_date'=>'string|required',
            'isbn'=>'string|required',
            'number_of_pages'=>'string|required',
        ];
    }
}
