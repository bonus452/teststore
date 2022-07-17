<?php

namespace App\Services;

use App\Models\Shop\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function update(Category $category, array $fields): Category
    {
        $parent = Category::withoutGlobalScope('withoutroot')->find($fields['category_id']);
        $parent->child()->save($category);
        $fields['slug'] = $fields['slug'] ?: Str::slug($fields['title']);
        $fields['url'] = $parent->getRawOriginal('url') . '/' . $fields['slug'];
        $category->update($fields);

        return $category;
    }

    public function store($fields)
    {
        $parent = Category::withoutGlobalScope('withoutroot')->find($fields['category_id']);
        $fields['slug'] = $fields['slug'] ?? Str::slug($fields['title']);
        $fields['url'] = $parent->getRawOriginal('url') . '/' . $fields['slug'];
        $result = $parent->child()->create($fields);

        return $result;
    }
}
