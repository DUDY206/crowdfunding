<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Models\CompanyInvest;
use App\Models\Language;
use App\Models\ContractTemplate;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index($slug, $invest_type_id, $locale)
    {
        $slug = Language::whereField('company-invest.slug')->where($locale,$slug)->firstOrFail();
        $company_invest = CompanyInvest::whereSlug($slug->id)->firstOrFail();
        // $contract = $company_invest->invest_type->firstWhere('id', $invest_type_id)->contract_template->sortBy(['created_at', 'desc'])->first();

        $contract = $company_invest->invest_type->firstWhere('id', $invest_type_id)->contract_template->sortBy(['created_at', 'desc']);

        return response()->json($contract , 200);
    }

    public function show($id)
    {
        $contract = ContractTemplate::findOrFail($id);

        return response()->json($contract , 200);
    }

    public function create_form($request)
    {

    }
}
