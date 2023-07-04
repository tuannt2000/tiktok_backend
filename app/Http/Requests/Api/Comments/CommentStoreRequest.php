<?php

namespace App\Http\Requests\Api\Comments;

use App\Http\Requests\Api\ApiRequest;

class CommentStoreRequest extends ApiRequest
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
           'text' => 'required|max:150',
           'video_id' => 'required|integer',
           'parent_comment_id' => 'nullable|integer'
        ];
    }
}
