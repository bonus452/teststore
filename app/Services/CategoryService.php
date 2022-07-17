<?php

namespace App\Services;

use App\Models\Shop\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function update($category, $fields){

    }

    public function store($fields){

        $parent = Category::withoutGlobalScope('withoutroot')->find($fields['category_id']);
        $fields['slug'] = $fields['slug'] ?? Str::slug($fields['title']);
        $fields['url'] = $parent->getRawOriginal('url') . '/' . $fields['slug'];
        $result = $parent->child()->create($fields);

        return $result;
    }
}
