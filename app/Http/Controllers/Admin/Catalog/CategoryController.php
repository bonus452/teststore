<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Catalog\Category;
use App\Repository\Breadcrumbs\Admin\CategoryBreadcrumb;
use App\Repository\CatalogRepository;
use App\Repository\CategoryRepository;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{

    private $categoryRepository;
    private $catalogRepository;
    private $breadcrumbCategory;
    private $categoryService;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
        $this->catalogRepository = new CatalogRepository();
        $this->breadcrumbCategory = new CategoryBreadcrumb();
        $this->categoryService = new CategoryService();
    }

    public function index()
    {
        $items = $this->catalogRepository->getPaginateWithCategories();
        return view('admin.catalog.list', compact('items'));
    }

    public function list(Request $request, $sub_categories)
    {
        $category = $this->categoryRepository->getFromUrl($request->getPathInfo());

        if ($category instanceof Category){
            $items = $this->catalogRepository->getPaginateWithCategories($category);
            $breadcrumbs = $this->breadcrumbCategory->getBreadcrumb($category);
            return view('admin.catalog.list', compact('items', 'breadcrumbs'));
        }else{
            abort(404);
        }

    }

    public function editForm(Category $category)
    {
        $categoriesTree = $this->categoryRepository->getForComboboxWithRoot($category->parent);
        $breadcrumbs = $this->breadcrumbCategory->getBreadcrumb($category);
        return view('admin.catalog.category.edit_form',
            compact('category', 'breadcrumbs', 'categoriesTree'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category = $this->categoryService->update($category, $request->safe()->all());
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
        $parent_category = $this->categoryRepository->getFromUrl($perview_url);
        $categoriesTree = $this->categoryRepository->getForComboboxWithRoot($parent_category);

        if ($parent_category instanceof Category) {
            $breadcrumbs = $this->breadcrumbCategory->getBreadcrumb($parent_category);
            return view('admin.catalog.category.create_form',
                compact('categoriesTree', 'breadcrumbs', 'parent_category'));
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
        if ($category->parent instanceof Category) {
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
