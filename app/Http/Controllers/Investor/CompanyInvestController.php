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
    public $pagination = 9;

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
        // return response()->json(
        //     CompanyInvest::orderBy('created_at', 'desc')->where('status', 1)->paginate($this->pagination)
        // );

        $company_invest = CompanyInvest::orderBy('created_at', 'desc')->where('status', 1);
        $company_invest = $company_invest->with([
            'company' => function ($query) {
                $query->select($this->fillableCompany);
            }
        ])->paginate($this->pagination, $this->fillableCompanyInvest);

        return response()->json($company_invest);
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
                // $company_invest = CompanyInvest::withCount('order')->where('status', 1)->orderBy('order_count', 'desc')->paginate($this->pagination);

                // $company_invest = CompanyInvest::all();
                // $company_invest = $company_invest->load('order');
                // $company_invest = CompanyInvest::withCount('order')->with('company')->where('status', 1)->orderBy('order_count', 'desc')->paginate($this->pagination);

                $company_invest = CompanyInvest::with([
                    'company' => function ($query) {
                        $query->select($this->fillableCompany);
                    },
                ])->select($this->fillableCompanyInvest)->withCount('order')->where('status', 1)->orderBy('order_count', 'desc')->paginate($this->pagination);

                return response()->json($company_invest);
                break;
        }
    }

    public function getCompanyInvestBeLikedByUser($accountId)
    {
        $user = User::findOrFail($accountId)->load('like_investment');
        $invests = $user->like_investment->pluck('id');
        $company_invest = CompanyInvest::whereIn('id', $invests)->orderByDesc('id')->paginate($this->pagination);
        $company_invest = Auth::guard('api')->check();

        return response()->json($company_invest);
    }

    public function getInvestByCategory($categorySlug, $locale)
    {
        $slug = Language::whereField('category.slug')->where($locale, $categorySlug)->firstOrFail();
        $category = Category::whereSlug($slug->id)->firstOrFail($this->fillableCategory);
        // $company_invest = $category->company_invest()->where('status', 1)->paginate($this->pagination);

        $company_invest = $category->company_invest()->with([
            'company' => function ($query) {
                $query->select($this->fillableCompany);
            },
        ])->paginate($this->pagination);

        return response()->json([
            'category' => $category,
            'company_invest' => $company_invest,
        ]);
    }

    // public function store(CompanyInvestRequest $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $request->validated();
    //         $list_company_invest_lang_request = Helper::createLanguageForArrayField($request,CompanyInvest::getLangArray(),'companyInvest');
    //         $company_invest = CompanyInvest::create(
    //             $request->except('img_url')+[
    //                 'img_url' => Helper::saveImage(null,$request->file('img_url'),'companyInvest/img')
    //             ]+
    //             $list_company_invest_lang_request);

    //         //IMMUTABLE FIELD
    //         $list_immutable_fields_request = $request->get('immutable_field'); //check if request has immutable field
    //         $lang_immutable_field = []; //array attribute to create model
    //         if($list_immutable_fields_request !== null){
    //             $lang_immutable_field =  Helper::createLanguageForArrayField($list_immutable_fields_request,InvestImmutableField::getLangArray(),'companyInvest.immutable_field');
    //             InvestImmutableField::create([
    //                 'invest_id' => $company_invest->id
    //             ]+$lang_immutable_field);
    //         }

    //         //MUTABLE FIELD
    //         $const_lang_mutable_field = InvestMutableField::getLangArray();
    //         $list_mutable_fields_input =  $request->get('mutable_field') ?? [];
    //         foreach ($list_mutable_fields_input as $mutable_field){
    //             $lang_mutable_field = Helper::createLanguageForArrayField($mutable_field,$const_lang_mutable_field,'companyInvest.mutable_field');
    //             InvestMutableField::create([
    //                 'invest_id' => $company_invest->id,
    //                 'position' => $mutable_field['position']
    //             ]+$lang_mutable_field);
    //         }

    //         DB::commit();
    //         return response()->json($company_invest->fresh());
    //     } catch (Exception $exception){
    //         DB::rollBack();

    //         return response()->json([
    //             'error' => $exception
    //         ]);
    //     }
    // }

    // public function show($id)
    // {
    //     try {
    //         $companyInvest = CompanyInvest::findOrFail($id);

    //         return response()->json($companyInvest);
    //     } catch (Exception $exception) {
    //         return  response()->json([
    //             'error' => 'Not found'
    //         ]);
    //     }
    // }

    // public function update(CompanyInvestRequest $request, $id)
    // {
    //     DB::beginTransaction();
    //     $company_invest = CompanyInvest::findOrFail($id);
    //     try {
    //         $request->validated();
    //         Helper::updateLanguageForArrayField($request,CompanyInvest::getLangArray(),$company_invest);
    //         $img_url = [];
    //         if($request->hasFile('img_url')){
    //             $img_url = ['img_url' => Helper::saveImage($company_invest->img_url,$request->file('img_url'),'companyInvest/img')];
    //         }
    //         $company_invest->update(
    //             $request->except(['img_url'])+
    //             $img_url
    //         );

    //         //IMMUTABLE FIELD
    //         $list_immutable_fields_request = $request->get('immutable_field');
    //         $company_immutable_field = $company_invest->fresh()->immutable_field;
    //         if($list_immutable_fields_request !== null)
    //             if($company_immutable_field !== null){
    //                 //edit
    //                 Helper::updateLanguageForArrayField($list_immutable_fields_request,InvestImmutableField::getLangArray(),$company_immutable_field);
    //             }else{
    //                 //create
    //                 $lang_immutable_field =  Helper::createLanguageForArrayField($list_immutable_fields_request,InvestImmutableField::getLangArray(),'companyInvest.immutable_field');
    //                 InvestImmutableField::create([
    //                         'invest_id' => $company_invest->id
    //                     ]+$lang_immutable_field);
    //             }

    //         //MUTABLE FIELD
    //         $invest_mutable_field = $company_invest->fresh()->mutable_field;
    //         foreach ($invest_mutable_field as $field){
    //             $field->delete();
    //         }

    //         $const_lang_mutable_field = InvestMutableField::getLangArray();
    //         $list_mutable_fields_input =  $request->get('mutable_field') ?? [];
    //         foreach ($list_mutable_fields_input as $mutable_field){
    //             $lang_mutable_field = Helper::createLanguageForArrayField($mutable_field,$const_lang_mutable_field,'companyInvest.immutable_field');
    //             InvestMutableField::create([
    //                     'invest_id' => $company_invest->id,
    //                     'position' => $mutable_field['position']
    //                 ]+$lang_mutable_field);
    //         }

    //         DB::commit();
    //         return response()->json($company_invest->fresh());
    //     }catch (Exception $exception){
    //         DB::rollBack();
    //         return response()->json([
    //             'error' => $exception
    //         ]);
    //     }
    // }

    // public function destroy($id)
    // {
    //     CompanyInvest::findOrFail($id)->delete();
    //     return response()->json([
    //         'message' => __('message-request.company-invest.delete')
    //     ]);
    // }
}
