<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestType;
use Illuminate\Http\Request;
use Mockery\Exception;

class InvestHasContractTemplateController extends Controller
{

    public function show($id)
    {
        $invest_type = InvestType::findOrFail($id);
        $list_contract_template = $invest_type->contract_template;
        return response()->json(
            $list_contract_template
        ,200);
    }
}
