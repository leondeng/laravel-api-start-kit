<?php

namespace Api\Requests;

class UpdateCommentRequest extends Request
{
    public function authorize()
    {
        return $this->user()->can('update', $this->comment);
    }

    public function rules()
    {
        return [
            'content' => 'required|string|max:255',
        ];
    }
}
