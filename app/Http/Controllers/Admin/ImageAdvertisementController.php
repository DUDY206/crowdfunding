<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImageAdvertisement;
use App\Helper;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ImageAdvertisementRequest;

class ImageAdvertisementController extends Controller
{
    public function index()
    {
        $images = ImageAdvertisement::orderByDesc('id')->paginate(10);

        return response()->json($images);
    }

    public function store(ImageAdvertisementRequest $request)
    {
        $data = $request->all();

        DB::beginTransaction();

        try {
            $data['img'] = Helper::saveImage(null, $request->file('img'), 'advertisement');
            ImageAdvertisement::create($data);
            DB::commit();

            return response()->json([
                'status' => true
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
        $image = ImageAdvertisement::findOrFail($id);

        return response()->json($image);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $image = ImageAdvertisement::findOrFail($id);

        DB::beginTransaction();

        try {
            $data['img'] = Helper::saveImage($image->img, $request->file('img'), 'advertisement');
            $image->update($data);
            DB::commit();

            return response()->json([
                'status' => true
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
        $image = ImageAdvertisement::findOrFail($id);
        $image->delete();

        return response()->json([
            'status' => true,
        ]);
    }
}
