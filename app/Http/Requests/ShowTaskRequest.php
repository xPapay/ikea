<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Task;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ShowTaskRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $task = Task::where('id', $this->tasks)->firstOrFail();

        return $task->viewableByUser(Auth::user());
    }

    /**
     * Get the response for a forbidden operation.
     *
     * @return \Illuminate\Http\Response
     */
    public function forbiddenResponse()
    {
        if ($this->ajax())
        {
            return new Response('Nemáte oprávnenia prezerať túto úlohu', 403);
        }

        return new Response(view('errors.403'), 403);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
