<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialCommentRequest;
use App\Models\SocialComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class SocialCommentController extends Controller
{

    public function store(SocialCommentRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->validated();
            if($request->has('reply_comment_id')){
                $reply_comment_id = ['reply_comment_id' => $request->get('reply_comment_id')];
                $social_comment = SocialComment::create([
                    'content' => $request->get('content'),
                    'account_id' => $request->user('api')->id
                ] + $reply_comment_id);
            } else {
                $social_comment = SocialComment::create([
                    'content' => $request->get('content'),
                    'invest_id' => $request->get('invest_id'),
                    'account_id' => $request->user('api')->id
                ]);
            }

            $social_comment = $social_comment->load([
                'user' => function($query) {
                    $query->select([
                        'id',
                        'user_name',
                        'slug',
                        'full_name',
                        'avatar',
                        'cover_photo',
                        'created_at'
                    ]);
                }
            ]);

            DB::commit();
            return response()->json($social_comment);
        }catch (Exception $exception){
            DB::rollBack();
            return response()->json([
                'error' => $exception
            ],JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    public function update(SocialCommentRequest $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
