<?php

namespace Modules\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use Laraeast\LaravelSettings\Facades\Settings;
use Modules\Categories\Entities\Category;
use Modules\Categories\Transformers\CategoryResource;
use Modules\Support\Traits\ApiTrait;

class SelectController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $categories = Category::orderBy("rank")->get();
        $data = [
            "show" => (bool) Settings::get('Category'),
            "header" => Settings::locale(app()->getLocale())->get('category_header'),
            "categories" => CategoryResource::collection($categories)
        ];

        return $this->sendResponse($data, "success");
    }
}
