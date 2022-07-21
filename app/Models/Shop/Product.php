<?php

namespace App\Models\Shop;

use App\Interfaces\RowGetteble;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Shop\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Shop\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Shop\Category $category
 * @property-read mixed $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\Offer[] $offers
 * @property-read int|null $offers_count
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 */
class Product extends Model implements RowGetteble
{
    use HasFactory;

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getUrlAttribute($value){
        $category_url = $this->category->url;
        return $category_url . '/detail-product/' . $this->slug;
    }

    public function getAdminUrl(){
        return '/admin/catalog/edit-product/' . $this->slug;
    }

}
