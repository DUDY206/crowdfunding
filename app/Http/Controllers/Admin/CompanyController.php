<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\CompanyInvest;
use App\Models\Language;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class CompanyController extends Controller
{
    public function index()
    {
        switch (Helper::getDomainSendRequest()){
            case "admin": {
            // case "admin-bestbcrowdfunding": {
                return response()->json(Company::with('owner')->orderByDesc('id')->paginate('10'));
            }
            case "company": {
            // case "company-bestbcrowdfunding": {
                $user = Auth::guard('api')->user();
                $company = $user->company;
                $company = $company instanceof Collection ? $company : Collection::make($company);
                $page = 1;

                if (count($_REQUEST) > 0) {
                    $page = $_REQUEST['page'] === null ? 1 : $_REQUEST['page'];
                }

                return response()->json(new LengthAwarePaginator($company->forPage($page, 10), $company->count(), 10, $page, []));
            }
        }
    }

    public function index_not_paging()
    {
        switch (Helper::getDomainSendRequest()){
            case "admin": {
            // case "admin-bestbcrowdfunding": {
                return response()->json(
                    Company::all()
                );
            }
            case "company": {
            // case "company-bestbcrowdfunding": {
                $user = Auth::guard('api')->user();

                return response()->json($user->company);
            }
        }

        return response()->json([]);
    }

    public function store(CompanyRequest $request)
    {
        DB::beginTransaction();

        try {
            $request->validated();
            $lang_description = [];
            $lang_company_type = [];
            $lang_location = [];
            $lang_name = Helper::createLanguage($request, 'name_vi', 'name_en', 'companies.name');

            //check if request has description
            $lang = Helper::createLanguage($request, 'description_vi', 'description_en', 'companies.description');
            if ($lang != null) {
                $lang_description = ['description' => $lang->id];
            }

            //check if request has company type
            $lang = Helper::createLanguage($request,'company_type_vi', 'company_type_en', 'companies.company_type');
            if ($lang != null) {
                $lang_company_type = ['company_type' => $lang->id];
            }

            $lang = Helper::createLanguage($request, 'location_vi', 'location_en', 'companies.location');
            if ($lang != null) {
                $lang_location = ['location' => $lang->id];
            }

            $company = Company::create(
                $request->except([
                    'name_vi', 'name_en', 'description_vi', 'description_en', 'company_type_vi', 'company_type_en', 'img_url'
                ]) + [
                    'name' => $lang_name->id,
                    'img_url' => Helper::saveImage(null, $request->file('img_url'), 'company/img')
                ] +
                    $lang_description+
                    $lang_company_type+
                    $lang_location
            );
            DB::commit();

            return response()->json($company->fresh());
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
            $company = Company::findOrFail($id);

            return response()->json($company);
        } catch (Exception $exception) {
            return response()->json([
                'error' => 'Not found'
            ]);
        }
    }

    public function update(CompanyRequest $request, $id)
    {
        DB::beginTransaction();
        $company = Company::findOrFail($id);

        try {
            $request->validated();
            $lang_description = [];
            $lang_company_type = [];
            $lang_name = $company->lang_name->update([
                'vi' => $request->get('name_vi'),
                'en' => $request->get('name_en'),
            ]);

            //check if request has description
            if ($request->has('description_vi') || $request->has('description_en')) {
                $lang = new Language();
                if ($company->description != null){
                    $lang = Language::findOrFail($company->description);
                }
                $lang->vi = $request->get('description_vi');
                $lang->en = $request->get('description_en');
                $lang->field = 'companies.description';
                $lang->save();
                $lang_description = [
                    'description' => $lang->id
                ];
            }

            //check if request has company type
            if ($request->has('company_type_vi') || $request->has('company_type_en')) {
                $lang = new Language();
                if ($company->description != null) {
                    $lang = Language::findOrFail($company->company_type);
                }

                $lang->vi = $request->get('company_type_vi');
                $lang->en = $request->get('company_type_en');
                $lang->field = 'companies.company_type';
                $lang->save();
                $lang_company_type = [
                    'company_type' => $lang->id
                ];
            }

            if ($request->has('location_vi') || $request->has('location_en')) {
                $lang = new Language();
                if ($company->location != null) {
                    $lang = Language::findOrFail($company->location);
                }

                $lang->vi = $request->get('location_vi');
                $lang->en = $request->get('location_en');
                $lang->field = 'companies.location';
                $lang->save();
                $lang_company_type = [
                    'location' => $lang->id
                ];
            }

            $company->update(
                $request->except([
                    'name_vi', 'name_en', 'description_vi', 'description_en', 'company_type_vi', 'company_type_en', 'location_vi', 'location_en', 'img_url'
                ]) + [
                    'img_url' => Helper::saveImage($company->img_url, $request->file('img_url'), 'company/img')
                ] +
                    $lang_description+
                    $lang_company_type
            );
            DB::commit();

            return response()->json($company->fresh());
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ]);
        }
    }

    public function destroy($id)
    {
        Company::findOrFail($id)->delete();

        return response()->json([
            'message' => __('message-request.company.delete')
        ]);
    }

    public function search(Request $request)
    {
        $key = $request->keyName;

        $company = Company::with('owner')->whereHas(
            'lang_name', function ($query) use ($key) {
                $query->where('vi', 'like', '%'.$key.'%');
            }
        )->paginate(10);

        $company->appends(['search' => $key]);

        return response()->json($company);
    }
}
