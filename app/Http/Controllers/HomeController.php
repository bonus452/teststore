<?php

namespace App\Http\Controllers;

use App\Repository\CategoryRepository;

class HomeController extends Controller
{

    private CategoryRepository $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }

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
