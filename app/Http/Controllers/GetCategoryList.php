<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Cache;
use Illuminate\Http\Request;

class GetCategoryList extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view("categories.index", [
            "categories" => Cache::rememberForever(
                "categories",
                fn() => Category::withCount("projects")->get()
            ),
        ]);
    }
}
