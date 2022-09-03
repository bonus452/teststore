<?php

namespace App\Services;

use App\Models\Shop\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function update(Category $category, array $fields): Category
    {
        $category->update($fields);
        return $category;
    }

    public function store($fields)
    {
        $parent = Category::withoutGlobalScope('withoutroot')->find($fields['category_id']);
        $fields['url'] = $parent->getRawOriginal('url') . '/' . $fields['slug'];
        $result = $parent->child()->create($fields);

        return $result;
    }
}
