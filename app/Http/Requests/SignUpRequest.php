<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed', 
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'skills' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'linkedinURL' => 'nullable|url|max:255',
        ];
    }

    /**
     * Customize the error messages for validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'The username is required.',
            'email.required' => 'The email address is required.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'firstName.required' => 'The first name is required.',
            'lastName.required' => 'The last name is required.',
            'frontIdPic.required' => 'The front ID picture is required.',
            'backIdPic.required' => 'The back ID picture is required.',
            'CV.required' => 'The CV file is required.',
            'bio.max' => 'The bio can be at most 500 characters long.',
            'linkedinURL.url' => 'The LinkedIn URL must be a valid URL.',
        ];
    }
}
