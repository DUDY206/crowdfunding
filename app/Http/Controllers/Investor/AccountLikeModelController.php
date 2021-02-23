<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountLikeModelRequest;
use App\Models\SocialComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class AccountLikeModelController extends Controller
{

    public function store(AccountLikeModelRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->validated();
            $is_liked = $request->get('is_liked');
            $user = $request->user('api');
            $model_type = $request->get('model_type');
            $model = null;

            switch ($model_type){
                case 'social_comment':{
                    $model = SocialComment::findOrFail($request->get('model_id'));
                }
            }

            if($is_liked){
                $user->like_comment()->detach($model);
            }else{
                $user->like_comment()->save($model);
            }

            DB::commit();
            return response()->json([
                'success' => '1',
            ]);
        }catch (Exception $exception){
            DB::rollBack();
            return response()->json([
                'error' => $exception
            ],JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
