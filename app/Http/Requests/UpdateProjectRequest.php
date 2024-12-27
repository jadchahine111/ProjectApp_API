<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $project = $this->route('id'); // Get project ID from route

        // Ensure the user is the owner of the project
        return $project && $project->userId === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|max:255|nullable',
            'description' => 'string|nullable',
            'skillsNeeded' => 'string|nullable',
            'status' => 'in:archived,active|nullable',
            'categoryId' => 'exists:categories,id|nullable',
            'amount' => 'integer|min:0|nullable',  
      ];
    }
}
