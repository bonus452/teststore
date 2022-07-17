<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Helpers\DataRefactor;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Shop\Category;
use App\Traits\HasAdminCatalogRepository;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    use HasAdminCatalogRepository;

    public function index()
    {
        $items = $this->productRepository->getPaginateWithCategories();
        return view('admin.catalog.list', compact('items'));
    }

    public function list(Request $request, $sub_categories)
    {
        $request_url = $request->getPathInfo();
        $category = $this->categoryRepository->getFromUrl($request_url);
        $items = $this->productRepository->getPaginateWithCategories($category);
        $breadcrumbs = $this->categoryRepository->getBreadcrumb($category);
        return view('admin.catalog.list', compact('items', 'breadcrumbs'));
    }

    public function editForm(Category $category, Request $request)
    {
        $parent = $category->parent;
        $categoriesTree = $this->categoryRepository->getForCombobox($parent);
        $breadcrumbs = $this->categoryRepository->getBreadcrumb($category);
        return view('admin.catalog.category.edit_form', compact('category', 'breadcrumbs', 'categoriesTree'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category = $this->categoryService->update($category, $request->all());
        }catch (Exception $exception){
            return back()
                ->withInput()
                ->withErrors(['category' => $exception->getMessage()]);
        }

        return redirect()
            ->route('admin.catalog.edit_form', compact('category'))
            ->with([RESULT_MESSAGE => 'Category updated successfully']);
    }

    public function createForm(Request $request)
    {
        $perview_url = redirect()->back()->getTargetUrl();
        $selectedCategory = $this->categoryRepository->getFromUrl($perview_url);

        $categoriesTree = $this->categoryRepository->getForCombobox($selectedCategory);
        $breadcrumbs = $this->categoryRepository->getBreadcrumb($selectedCategory);
        return view('admin.catalog.category.create_form', compact('categoriesTree', 'breadcrumbs'));
    }

    public function create(CategoryRequest $request)
    {

        try {
            $category = $this->categoryService->store($request->all());
        }catch (Exception $exception){
            return back()
                ->withInput()
                ->withErrors(['category' => $exception->getMessage()]);
        }

        return redirect()
            ->route('admin.catalog.edit_form', compact('category'))
            ->with([RESULT_MESSAGE => 'Category created successfully']);
    }

}
