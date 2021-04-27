<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function show($id, $locale)
    {
        $news = News::findOrFail($id);

        return response()->json($news);
    }
}
