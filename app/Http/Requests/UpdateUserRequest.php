<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'string|max:255|unique:users,username,' . $this->route('id'),
            'firstName' => 'string|max:255',
            'lastName' => 'string|max:255',
            'CV' => 'file|mimes:pdf,doc,docx|max:2048',
            'bio' => 'string|nullable',
            'linkedinURL' => 'url|nullable',
            'skills' => 'string|nullable',
        ];
    }
}
