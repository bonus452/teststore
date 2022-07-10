<?php

namespace App\Http\Controllers;

use App\Repository\CategoryRepository;
use App\Traits\HasAdminCatalogRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    use HasAdminCatalogRepository;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $catalog_menu = $this->categoryRepository->getCategoriesTree();
        return view('index', compact('catalog_menu'));
    }
}
