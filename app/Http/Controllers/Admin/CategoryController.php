<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helper;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('id')->paginate(20);

        return response()->json($categories);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        DB::beginTransaction();

        try {
            $category_lang = Helper::createLanguageForArrayField($request, Category::getLangArray(), 'category');
            $category_created = Category::create([
                'logo'          => Helper::saveImage(null, $request->file('logo'), 'categories/logo'),
                'img_cover'     => Helper::saveImage(null, $request->file('img_cover'), 'categories/cover'),
            ] + $category_lang);

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

    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();
        $categories = Category::findOrFail($id);

        DB::beginTransaction();

        try {
            Helper::updateLanguageForArrayField($request, Category::getLangArray(), $categories, 'category');

            if ($request->file('img_cover') === null) {
                $old_file = 'storage/categories/cover/' . $categories->img_cover;
                if (file_exists($old_file)) {
                    unlink($old_file);
                }

                $img_cover_new = null;
            } else {
                $img_cover_new = Helper::saveImage($categories->img_cover, $request->file('img_cover'), 'categories/cover');
            }

            $categories->update([
                'logo'      => Helper::saveImage($categories->logo, $request->file('logo'), 'categories/logo'),
                'img_cover' => $img_cover_new,
            ]);

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
            Category::findOrFail($id)->delete();

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

    public function addInvestToCategory(Request $request, $categoryId)
    {
        $data = $request->all();
        $data['invest_id'] = json_decode($data['invest_id']);
        $category = Category::findOrFail($categoryId);

        DB::beginTransaction();

        try {
            $category->company_invest()->detach();
            $category->company_invest()->sync($data['invest_id']);

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
