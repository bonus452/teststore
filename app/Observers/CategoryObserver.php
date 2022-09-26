<?php

namespace App\Observers;

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Repository\CategoryRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryObserver
{

    /**
     * Handle the Category "creating" event.
     *
     * @param \App\Models\Catalog\Category $category
     * @return \App\Models\Catalog\Category  $category
     */
    public function creating(Category $category): Category
    {
        $category->slug = $category->slug ?: Str::slug($category->title);
        if ($category->image instanceof UploadedFile) {
            if ($category->image) {
                $category->image = $category->image->storePublicly('images/category_images', 'public');
            }
        }
        return $category;
    }

    /**
     * Handle the Category "updating" event.
     *
     * @param \App\Models\Catalog\Category $category
     * @return Category
     */
    public function updating(Category $category): Category
    {
        $category->slug = $category->slug ?: Str::slug($category->title);

        $parent = Category::withoutGlobalScope('withoutroot')->find($category->category_id);
        $category->url = $parent->getRawOriginal('url') . '/' . $category->slug;

        $old_img = $category->getImageSystemPath();
        if ($old_img) {
            File::delete($old_img);
        }
        if ($category->image instanceof UploadedFile) {
            if ($category->image) {
                $category->image = $category
                    ->image
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
