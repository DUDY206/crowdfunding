<?php

namespace App\Http\Controllers\Investor;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyInvestRequest;
use App\Models\User;
use App\Models\Company;
use App\Models\CompanyInvest;
use App\Models\InvestImmutableField;
use App\Models\InvestMutableField;
use App\Models\Language;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mockery\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;

class CompanyInvestController extends Controller
{
    public $pagination = 15;

    public $fillableCategory = [
        'id',
        'logo',
        'img_cover',
        'name',
        'slug',
        'description',
    ];

    public $fillableCompany = [
        'id',
        'img_url',
        'video_url',
    ];

    public $fillableCompanyInvest = [
        'id',
        'name',
        'slug',
        'short_description',
        'img_url',
        'video_url',
        'min_invest',
        'valuation_cap',
        'location',
        'status',
        'company_id',
    ];

    public $fillableOrder = [
        'id',
        'invest_id',
    ];

    public function index()
    {
        $company_invest = CompanyInvest::orderBy('created_at', 'desc')->where('status', 1);

        if (Auth::guard('api')->user()) {
            $company_invest = $company_invest->with([
                'company' => function ($query) {
                    $query->select($this->fillableCompany);
                }
            ])->paginate($this->pagination, $this->fillableCompanyInvest);

            return response()->json($company_invest);
        } else {
            $company_invest = $company_invest->with([
                'company' => function ($query) {
                    $query->select($this->fillableCompany);
                }
            ])->take(3)->get($this->fillableCompanyInvest);

            return response()->json([
                'limit_data' => true,
                'data' => $company_invest
            ]);
        }
    }

    public function getCompanyInvestBySlug($slug, $locale)
    {
        try {
            $slug = Language::whereField('company-invest.slug')->where($locale, $slug)->firstOrFail();
            $company_invest = CompanyInvest::whereSlug($slug->id)->firstOrFail();
            $company_invest->load([
                'company',
                'immutable_field',
                'faq',
                'risks',
                'social_comment' => function($query) {
                    $query->with([
                        'user' => function($queryUser) {
                            $queryUser->select([
                                'id',
                                'user_name',
                                'slug',
                                'full_name',
                                'avatar',
                                'cover_photo',
                                'created_at'
                            ]);
                        },
                        'reply_comments' => function($queryRepCmt) {
                            $queryRepCmt->with([
                                'user' => function($queryUserRep) {
                                    $queryUserRep->select([
                                        'id',
                                        'user_name',
                                        'slug',
                                        'full_name',
                                        'avatar',
                                        'cover_photo',
                                        'created_at'
                                    ]);
                                },
                            ]);
                        }
                    ])->get();
                },
                'invest_type',
                'contract_field',
                'news' => function($query) {
                    $query->orderByDesc('created_at')->take($this->pagination);
                },
            ])->append([
                'company_name',
                'is_like_by_current_user',
                'total_invested_money',
                'date_expired_diff',
                'user_in_invest'
            ]);

            return response()->json($company_invest);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'not_found'
            ]);
        }
    }

    public function getCompanyInvestByUser($slug, $locale)
    {
        $user = User::where('slug', $slug)->with([
            'orders' => function ($query) {
                $query->where('payment_status', 3);
            }
        ])->get();

        $orders = $user[0]->orders;

        $investId = [];

        foreach ($orders as $order) {
            array_push($investId, $order->invest_id);
        }

        $investId = array_unique($investId, 0);

        $company_invest = CompanyInvest::whereIn('id', $investId)->with([
            'company' => function ($query) {
                $query->select($this->fillableCompany);
            }
        ])->where('status', 1)->get($this->fillableCompanyInvest);

        return response()->json($company_invest);
    }

    public function getCompanyInvestBySort($sort)
    {
        switch ($sort) {
            case 1:
                if (Auth::guard('api')->user()) {
                    $company_invest = CompanyInvest::with([
                        'company' => function ($query) {
                            $query->select($this->fillableCompany);
                        },
                    ])->select($this->fillableCompanyInvest)
                    ->withCount('order')
                    ->where('status', 1)
                    ->orderBy('order_count', 'desc')
                    ->paginate($this->pagination);

                    return response()->json($company_invest);
                } else {
                    $company_invest = CompanyInvest::with([
                        'company' => function ($query) {
                            $query->select($this->fillableCompany);
                        },
                    ])->withCount('order')
                    ->where('status', 1)
                    ->orderBy('order_count', 'desc')
                    ->take(3)
                    ->get($this->fillableCompanyInvest);

                    return response()->json([
                        'limit_data' => true,
                        'data' => $company_invest
                    ]);
                }
                break;
        }
    }

    public function getInvestByCategory($categorySlug, $locale)
    {
        $slug = Language::whereField('category.slug')->where($locale, $categorySlug)->firstOrFail();
        $category = Category::whereSlug($slug->id)
            ->where('status', 1)
            ->firstOrFail($this->fillableCategory);

        if (Auth::guard('api')->user()) {
            $company_invest = $category->company_invest()->with([
                'company' => function ($query) {
                    $query->select($this->fillableCompany);
                },
            ])->where('status', 1)->paginate($this->pagination);

            return response()->json([
                'category' => $category,
                'company_invest' => $company_invest,
            ]);
        } else {
            $company_invest = $category->company_invest()->with([
                'company' => function ($query) {
                    $query->select($this->fillableCompany);
                },
            ])->where('status', 1)->take(3)->get();

            return response()->json([
                'limit_data' => true,
                'category' => $category,
                'company_invest' => [
                    'data' => $company_invest,
                ],
            ]);
        }
    }

    public function getCompanyInvestBeLikedByUser()
    {
        $arrayMorph = [
            0 => 'model_id as id'
        ];
        $fillableResult = array_replace($this->fillableCompanyInvest, $arrayMorph);
        $user = Auth::guard('api')->user();

        if ($user) {
            $company_invest = $user->like_investment()->with([
                'company' => function ($query) {
                    $query->select($this->fillableCompany);
                }
            ])->where('status', 1)->paginate($this->pagination, $fillableResult);

            return response()->json($company_invest);
        } else {
            return response()->json([
                'status' => false
            ]);
        }
    }
}
