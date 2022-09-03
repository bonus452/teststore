<?php

namespace App\Observers;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Repository\CatalogRepository;
use App\Repository\CategoryRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryObserver
{

    /**
     * Handle the Category "creating" event.
     *
     * @param \App\Models\Shop\Category $category
     * @return \App\Models\Shop\Category  $category
     */
    public function creating(Category $category): Category
    {
        $category->slug = $category->slug ?: Str::slug($category->title);
        if ($category->img instanceof UploadedFile) {
            if ($category->img) {
                $category->img = $category->img->storePublicly('images/category_images', 'public');
            }
        }
        return $category;
    }

    /**
     * Handle the Category "updating" event.
     *
     * @param \App\Models\Shop\Category $category
     * @return Category
     */
    public function updating(Category $category): Category
    {
        $category->slug = $category->slug ?: Str::slug($category->title);

        $parent = Category::withoutGlobalScope('withoutroot')->find($category->category_id);
        $category->url = $parent->getRawOriginal('url') . '/' . $category->slug;

        $old_img = $category->img_path_system;
        if ($old_img) {
            File::delete($old_img);
        }
        if ($category->img instanceof UploadedFile) {
            if ($category->img) {
                $category->img = $category
                    ->img
                    ->storePublicly('images/category_images', 'public');
            }
        }
        return $category;
    }

    public function updated(Category $category)
    {
        if ($category->parent instanceof Category) {
            $url = $category->parent->url . '/' . $category->slug;
            $category->child()
                ->get()
                ->each
                ->update(['url' => $url]);
        }
    }

    public function deleting(Category $category)
    {
        $repo = new CategoryRepository();
        $innerCategories = $repo->getAllChildrenId($category->id);
        Product::whereIn('category_id', $innerCategories)
            ->get()
            ->each
            ->delete();
    }

}
