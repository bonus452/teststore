<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Shop\Category;
use App\Repository\Breadcrumbs\Admin\CategoryBreadcrumb;
use App\Repository\Breadcrumbs\Admin\ProductBreadcrumb;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{

    private $productRepository;
    private $categoryRepository;
    private $breadcrumbCategory;
    private $categoryService;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->breadcrumbCategory = new CategoryBreadcrumb();
        $this->categoryService = new CategoryService();
    }

    public function index()
    {
        $items = $this->productRepository->getPaginateWithCategories();
        return view('admin.catalog.list', compact('items'));
    }

    public function list(Request $request, $sub_categories)
    {

        $request_url = $request->getPathInfo();
        $category = $this->categoryRepository->getFromUrl($request_url);

        if ($category instanceof Category){
            $items = $this->productRepository->getPaginateWithCategories($category);
            $breadcrumbs = $this->breadcrumbCategory->getBreadcrumb($category);
            return view('admin.catalog.list', compact('items', 'breadcrumbs'));
        }else{
            abort(404);
        }

    }

    public function editForm(Category $category)
    {
        $parent = $category->parent;
        $categoriesTree = $this->categoryRepository->getForCombobox($parent);
        $breadcrumbs = $this->breadcrumbCategory->getBreadcrumb($category);
        return view('admin.catalog.category.edit_form',
            compact('category', 'breadcrumbs', 'categoriesTree'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category = $this->categoryService->update($category, $request->all());
        } catch (Exception $exception) {
            return back()
                ->withInput()
                ->withErrors(['category' => $exception->getMessage()]);
        }

        return redirect()
            ->route('admin.catalog.category.edit_form', compact('category'))
            ->with([RESULT_MESSAGE => __('success.category_updated')]);
    }

    public function createForm(Request $request)
    {
        $perview_url = redirect()->back()->getTargetUrl();
        $selectedCategory = $this->categoryRepository->getFromUrl($perview_url);
        $categoriesTree = $this->categoryRepository->getForCombobox($selectedCategory);

        if (!is_null($selectedCategory)) {
            $breadcrumbs = $this->breadcrumbCategory->getBreadcrumb($selectedCategory);
            return view('admin.catalog.category.create_form',
                compact('categoriesTree', 'breadcrumbs', 'selectedCategory'));
        } else {
            return view('admin.catalog.category.create_form',
                compact('categoriesTree'));
        }
    }

    public function create(CategoryRequest $request)
    {

        try {
            $category = $this->categoryService->store($request->all());
        } catch (Exception $exception) {
            return back()
                ->withInput()
                ->withErrors(['category' => $exception->getMessage()]);
        }

        return redirect()
            ->route('admin.catalog.category.edit_form', compact('category'))
            ->with([RESULT_MESSAGE => __('success.category_created')]);
    }

    public function delete(Category $category)
    {
        if (!is_null($category->parent)) {
            $url = $category->parent->getAdminUrl();
        } else {
            $url = route('admin.catalog.index');
        }
        try {
            if ($category->delete()) {
                return redirect($url)->with(RESULT_MESSAGE, __('success.category_deleted'));
            } else {
                return back()->withErrors(['category' => __('fail.category_delete')]);
            }
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->withErrors(['category' => __('fail.category_delete')]);

        }
    }

}
