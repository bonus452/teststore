<?php

namespace App\Observers;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class CategoryObserver
{

    /**
     * Handle the Category "creating" event.
     *
     * @param \App\Models\Shop\Category $category
     * @return \App\Models\Shop\Category  $category
     */
    public function creating(Category $category)
    {
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
    public function updating(Category $category)
    {

        $old_img = $category->img_path_system;
        if ($old_img) {
            File::delete($old_img);
        }
        if ($category->img instanceof UploadedFile) {
            if ($category->img) {
                $category->img = $category->img->storePublicly('images/category_images', 'public');
            }
        }
        return $category;
    }


    public function deleting(Category $category)
    {
        $repo = new CategoryRepository();
        $innerCategories = $repo->getAllChildsList($category->id);
        Product::whereIn('category_id', $innerCategories)
            ->get()
            ->each
            ->delete();
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param \App\Models\Shop\Category $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param \App\Models\Shop\Category $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
