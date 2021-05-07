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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderByDesc('id')->paginate(20);

        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $categories = Category::findOrFail($id);

        DB::beginTransaction();

        try {
            Helper::updateLanguageForArrayField($request, Category::getLangArray(), $categories, 'category');

            $categories->update([
                'logo'      => Helper::saveImage($categories->img_url, $request->file('logo'), 'categories/logo'),
                'img_cover' => Helper::saveImage($categories->img_url, $request->file('img_cover'), 'categories/cover'),
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
}
