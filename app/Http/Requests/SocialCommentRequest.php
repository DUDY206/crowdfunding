<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialCommentRequest extends TraitRequest
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
            'content' => 'required',
            'invest_id' => 'nullable|exists:company_investments,id',
            'reply_comment_id' => 'nullable|exists:social_comments,id',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => __('message-request.social-comment.content'),
            'invest_id.required' => __('message-request.social-comment.invest_id'),
            'reply_comment_id.exists' => __('message-request.social-comment.reply_comment_id'),
        ];
    }
}
