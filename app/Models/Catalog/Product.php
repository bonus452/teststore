<?php

namespace App\Models\Catalog;

use App\Filters\ProductFilter;
use App\Filters\QueryFilter;
use App\Interfaces\RowGetteble;
use App\Traits\CustomProperties;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
 * @method static \Database\Factories\Catalog\ProductFactory factory(...$parameters)
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
 * @property-read \App\Models\Catalog\Category $category
 * @property-read mixed $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalog\Offer[] $offers
 * @property-read int|null $offers_count
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalog\PropertyValue[] $properties
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalog\Image[] $images
 * @property-read int|null $images_count
 * @method static Builder|Product filter(\App\Filters\QueryFilter $filter)
 * @method static Builder|Product withProperties()
 * @property-read \App\Models\Catalog\Image|null $firstImage
 * @property-read \App\Models\Catalog\Offer|null $firstOffer
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'slug',
        'active',
        'seo_title',
        'seo_description',
        'seo_keywords'
    ];


    public function scopeActive(Builder $query)
    {
        $query->where('active', 1);
    }

    public function scopeFilter(Builder $query, QueryFilter $filter)
    {
        $filter->apply($query);
    }

    public function scopeWithProperties($query)
    {
        $query->with('properties', function ($query) {
            $query->with('property_name');
        });
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function firstOffer(): HasOne
    {
        return $this->hasOne(Offer::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function firstImage(): HasOne
    {
        return $this->hasOne(Image::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function properties(): MorphToMany
    {
        return $this->morphToMany(PropertyValue::class, 'propertable');
    }

    public function getFirstImageSrc()
    {
        if($image = $this->firstImage){
            return $image->src;
        }else{
            return NO_IMAGE;
        }
    }

    public function getUrlAttribute($value): string
    {
        $category_url = $this->category->url;
        return $category_url . '/detail-product/' . $this->slug;
    }

    public function getAdminUrl(): string
    {
        return '/admin/catalog/product-edit/' . $this->id;
    }

}
