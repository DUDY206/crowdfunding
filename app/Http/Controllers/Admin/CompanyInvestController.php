<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyInvestRequest;
use App\Models\Company;
use App\Models\CompanyInvest;
use App\Models\InvestImmutableField;
use App\Models\InvestMutableField;
use App\Models\Language;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mockery\Exception;

class CompanyInvestController extends Controller
{
    public $pagination = 10;

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
        'name',
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
        switch (Helper::getDomainSendRequest()) {
            case "admin": {
            // case "admin-bestbcrowdfunding": {
                $company_invest = CompanyInvest::orderBy('created_at', 'desc');
                // $company_invest = $company_invest->with([
                //     'company' => function ($query) {
                //         $query->select($this->fillableCompany);
                //     },
                //     'immutable_field',
                //     'mutable_field',
                //     'faq',
                //     'risks',
                //     'social_comment',
                //     'invest_type',
                //     'contract_field'
                // ])->paginate($this->pagination, $this->fillableCompanyInvest);

                $company_invest = $company_invest->with([
                    'company' => function ($query) {
                        $query->select($this->fillableCompany);
                    },
                ])->paginate($this->pagination, $this->fillableCompanyInvest);

                return response()->json($company_invest);
            }
            case "company": {
            // case "company-bestbcrowdfunding": {
                $user = Auth::guard('api')->user();
                $company_invest = new Collection();

                foreach ($user->company as $company) {
                    $company_invest = $company_invest->merge($company->company_invest);
                }

                $company_invest = $company_invest instanceof Collection ? $company_invest : Collection::make($company_invest);
                $page = 1;

                if (count($_REQUEST) > 0) {
                    $page = $_REQUEST['page'] === null ? 1 : $_REQUEST['page'];
                }

                return response()->json(new LengthAwarePaginator($company_invest->forPage($page, 10), $company_invest->count(), 10, $page, []));
            }
            case "investor": {
            // case "investor-bestbcrowdfunding": {
                return response()->json(
                    CompanyInvest::paginate(15)
                );
            }
        }

        return response()->json(new LengthAwarePaginator(Collection::make([])->forPage(1, 10), 0, 10, 1, []));
    }

    public function store(CompanyInvestRequest $request)
    {
        // return response()->json(Helper::saveImage(null, $request->file('img_url'), 'companyInvest/img'));

        DB::beginTransaction();

        try {
            $request->validated();
            $list_company_invest_lang_request = Helper::createLanguageForArrayField($request, CompanyInvest::getLangArray(), 'companyInvest');
            $company_invest = CompanyInvest::create(
                $request->except('img_url') + [
                    'img_url' => Helper::saveImage(null, $request->file('img_url'), 'companyInvest/img')
                ] +
                    $list_company_invest_lang_request
            );

            //IMMUTABLE FIELD
            $list_immutable_fields_request = $request->get('immutable_field'); //check if request has immutable field
            $lang_immutable_field = []; //array attribute to create model

            if ($list_immutable_fields_request !== null) {
                $lang_immutable_field =  Helper::createLanguageForArrayField($list_immutable_fields_request, InvestImmutableField::getLangArray(), 'companyInvest.immutable_field');
                InvestImmutableField::create([
                    'invest_id' => $company_invest->id
                ] + $lang_immutable_field);
            }

            //MUTABLE FIELD
            $const_lang_mutable_field = InvestMutableField::getLangArray();
            $list_mutable_fields_input =  $request->get('mutable_field') ?? [];
            foreach ($list_mutable_fields_input as $mutable_field) {
                $lang_mutable_field = Helper::createLanguageForArrayField($mutable_field, $const_lang_mutable_field, 'companyInvest.mutable_field');

                InvestMutableField::create([
                    'invest_id' => $company_invest->id,
                    'position' => $mutable_field['position']
                ] + $lang_mutable_field);
            }

            DB::commit();

            // return response()->json($company_invest->fresh());
            return response()->json([
                'status' => true,
                'message' => 'create success'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ]);
        }
    }

    public function show($id)
    {
        try {
            $company_invest = CompanyInvest::findOrFail($id);
            $company_invest = $company_invest->load([
                'company' => function ($query) {
                    $query->select($this->fillableCompany);
                },
                'immutable_field',
                'mutable_field',
                'faq',
                'risks',
                'social_comment',
                'invest_type',
                'contract_field'
            ])->append([
                'array_invest_type',
            ]);

            return response()->json($company_invest);
        } catch (Exception $exception) {
            return  response()->json([
                'error' => 'Not found'
            ]);
        }
    }

    public function update(CompanyInvestRequest $request, $id)
    {
        DB::beginTransaction();
        $company_invest = CompanyInvest::findOrFail($id);

        try {
            $request->validated();
            $img_url = [];

            Helper::updateLanguageForArrayField($request, CompanyInvest::getLangArray(), $company_invest);

            if ($request->hasFile('img_url')) {
                $img_url = [
                    'img_url' => Helper::saveImage($company_invest->img_url, $request->file('img_url'), 'companyInvest/img')
                ];
            }

            $company_invest->update(
                $request->except(['img_url']) + $img_url
            );

            //IMMUTABLE FIELD
            $list_immutable_fields_request = $request->get('immutable_field');
            $company_immutable_field = $company_invest->fresh()->immutable_field;
            if ($list_immutable_fields_request !== null)
                if ($company_immutable_field !== null) {
                    //edit
                    Helper::updateLanguageForArrayField($list_immutable_fields_request, InvestImmutableField::getLangArray(), $company_immutable_field);
                } else {
                    //create
                    $lang_immutable_field = Helper::createLanguageForArrayField($list_immutable_fields_request, InvestImmutableField::getLangArray(), 'companyInvest.immutable_field');

                    InvestImmutableField::create([
                        'invest_id' => $company_invest->id
                    ] + $lang_immutable_field);
                }

            //MUTABLE FIELD
            $invest_mutable_field = $company_invest->fresh()->mutable_field;
            foreach ($invest_mutable_field as $field) {
                $field->delete();
            }

            $const_lang_mutable_field = InvestMutableField::getLangArray();
            $list_mutable_fields_input =  $request->get('mutable_field') ?? [];
            foreach ($list_mutable_fields_input as $mutable_field) {
                $lang_mutable_field = Helper::createLanguageForArrayField($mutable_field, $const_lang_mutable_field, 'companyInvest.mutable_field');

                InvestMutableField::create([
                    'invest_id' => $company_invest->id,
                    'position' => $mutable_field['position']
                ] + $lang_mutable_field);
            }

            DB::commit();

            // return response()->json($company_invest->fresh());
            return response()->json([
                'status' => true,
                'message' => 'update success'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            CompanyInvest::findOrFail($id)->delete();

            DB::commit();

            return response()->json([
                'message' => __('message-request.company-invest.delete')
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ]);
        }
    }

    public function search(Request $request)
    {
        $key = $request->keyName;

        $company_invest = CompanyInvest::with([
            'company' => function ($query) {
                $query->select($this->fillableCompany);
            },
        ])->whereHas(
            'lang_name', function ($query) use($key) {
                $query->where('vi', 'like', '%'.$key.'%');
            }
        )->paginate($this->pagination);

        $company_invest->appends(['search' => $key]);

        return response()->json($company_invest);
    }
}
