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
    public $fillableCategory = [
        'id',
        'logo',
        'name',
        'slug',
        'description'
    ];

    public function getAll($status)
    {
        switch ($status) {
            case 0:
                $categories = Category::orderBy('level', 'asc')->where('status', 1)->get($this->fillableCategory);

                return response()->json($categories);
            case 1:
                $categories = Category::orderBy('level', 'asc')->where('status', 1)->take(5)->get($this->fillableCategory);

                return response()->json($categories);
        }
    }
}
