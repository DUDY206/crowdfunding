<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\CompanyInvest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\News;
use App\Helper;
use App\Http\Requests\NewsRequest;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('company_invest')->orderByDesc('id')->paginate(10);

        return response()->json($news);
    }

    public function getNewsOfInvest($investId)
    {
        $company_invest = CompanyInvest::findOrFail($investId)->load('news');
        $news = $company_invest->news()->OrderByDesc('id')->paginate(1);

        return response()->json($news);
    }

    public function store(NewsRequest $request)
    {
        $data = $request->all();
        $data['invest_id'] = json_decode($data['invest_id']);

        DB::beginTransaction();

        try {
            $news_lang = Helper::createLanguageForArrayField($request, News::getLangArray(), 'news');
            $news_created = news::create([
                'img_url' => Helper::saveImage(null, $request->file('img_url'), 'news'),
                'total_like' => 0
            ] + $news_lang);
            $news_created->company_invest()->sync($data['invest_id']);

            DB::commit();

            return response()->json([
                'success' => true,
            ], 200);

        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(NewsRequest $request, $id)
    {
        $data = $request->all();
        $data['invest_id'] = json_decode($data['invest_id']);
        $news = News::findOrFail($id);

        DB::beginTransaction();

        try {
            Helper::updateLanguageForArrayField($request, News::getLangArray(), $news, 'news');

            $news->update([
                'img_url' => Helper::saveImage($news->img_url, $request->file('img_url'), 'news'),
            ]);

            $news->company_invest()->detach();
            $news->company_invest()->sync($data['invest_id']);

            DB::commit();

            return response()->json([
                'success' => true
            ], 200);

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
            News::findOrFail($id)->delete();

            DB::commit();

            return response()->json([
                'status' => true,
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => $exception
            ]);
        }
    }
}
