<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImageAdvertisement;

class ImageAdvertisementController extends Controller
{
    public function index()
    {
        $images = ImageAdvertisement::orderByDesc('sort_level')->where('status', 0)->get();

        return response()->json($images);
    }
}
