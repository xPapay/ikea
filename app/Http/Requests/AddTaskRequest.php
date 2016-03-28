<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddTaskRequest extends Request
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
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'deadline' => 'required|date_format:d. m. Y',
            'executorsList' => 'required',
        ];

        $files = $this->file( 'files' );

        if ( !empty( $files ) ) {
            foreach ($files as $key => $file) // add individual rules to each image
            {
                $rules[sprintf('files.%d', $key)] = 'max:2000';
            }
        }
        return $rules;
    }
}
