<?php

namespace App\Observers;

use App\Models\Shop\Category;
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
                $category->img = $category->img->store('images/category_images', 'public');
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
                $category->img = $category->img->store('images/category_images', 'public');
            }
        }
        return $category;
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param \App\Models\Shop\Category $category
     * @return void
     */
    public function deleted(Category $category)
    {
        //
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
