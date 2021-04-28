<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Language;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderByDesc('created_at')->paginate(10);

        return response()->json($news);
    }

    public function getNewsBySlug($slug, $locale)
    {
        $slug = Language::whereField('news.slug')->where($locale, $slug)->firstOrFail();
        $news = News::whereSlug($slug->id)->firstOrFail();

        return response()->json($news);
    }
}
