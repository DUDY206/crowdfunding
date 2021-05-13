<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountLikeModelRequest;
use App\Models\CompanyInvest;
use App\Models\SocialComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class AccountLikeModelController extends Controller
{
    public $fillableUser = [
        'user_name',
        'slug',
        'full_name',
        'email',
        'phone_number',
        'date_of_birth',
        'avatar',
        'cover_photo',
        'description',
        'slogan',
        'created_at'
    ];

    public function like(Request $request, $status)
    {
        $user = User::findOrFail($request->get('user_id'));

        if ($status == 0) {
            return response()->json($user->follow_user);
        } else {
            return response()->json($user->follow_user->take(3));
        }
    }

    public function beliked(Request $request, $status)
    {
        $user = User::findOrFail($request->get('user_id'));

        if ($status == 0) {
            return response()->json($user->be_followed);
        } else {
            return response()->json($user->be_followed->take(3));
        }
    }

    public function store(AccountLikeModelRequest $request)
    {
        DB::beginTransaction();

        try {
            $request->validated();
            $is_liked = $request->get('is_liked');
            $user = $request->user('api');
            $model_type = $request->get('model_type');
            $model = null;

            switch ($model_type) {
                case 'social_comment': {
                    $model = SocialComment::findOrFail($request->get('model_id'));

                    if ($is_liked) {
                        $user->like_comment()->detach($model);
                    } else {
                        $user->like_comment()->save($model);
                    }

                    break;
                }
                case 'user': {
                    $model = User::findOrFail($request->get('model_id'));

                    if ($is_liked) {
                        $user->follow_user()->detach($model);
                    } else {
                        $user->follow_user()->save($model);
                    }

                    break;
                }
                case 'investment': {
                    $model = CompanyInvest::findOrFail($request->get('model_id'));

                    if ($is_liked) {
                        $user->like_investment()->detach($model);
                    } else {
                        $user->like_investment()->save($model);
                    }

                    break;
                }
            }

            DB::commit();

            return response()->json([
                'success' => '1',
            ]);
        }catch (Exception $exception){
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
