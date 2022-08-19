<?php

namespace App\Models\Shop;

use App\Interfaces\RowGetteble;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\PropertyValue[] $properties
 * @property-read int|null $properties_count
 * @property int $active
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereActive($value)
 * @method static Builder|Product active()
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_keywords
 * @method static Builder|Product whereSeoDescription($value)
 * @method static Builder|Product whereSeoKeywords($value)
 * @method static Builder|Product whereSeoTitle($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\Image[] $images
 * @property-read int|null $images_count
 */
class Product extends Model implements RowGetteble
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category_id', 'slug', 'active', 'seo_title', 'seo_description', 'seo_keywords'];


    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function properties() : MorphToMany
    {
        return $this->morphToMany(PropertyValue::class,'propertable');
    }

    public function getUrlAttribute($value)
    {
        $category_url = $this->category->url;
        return $category_url . '/detail-product/' . $this->slug;
    }

    public function getAdminUrl()
    {
        return '/admin/catalog/product-edit/' . $this->id;
    }

}
