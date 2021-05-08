<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CompanyInvest;
use App\Models\Language;
use App\Helper;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function getAll($status)
    {
        switch ($status) {
            case 0:
                $categories = Category::orderByDesc('id')->paginate(10);

                return response()->json($categories);
            case 1:
                $categories = Category::orderByDesc('id')->take(5)->get();

                return response()->json($categories);
        }
    }
}
