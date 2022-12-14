<?php

namespace App\Models\Catalog;

use App\Traits\CustomProperties;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Shop\Offer
 *
 * @property int $id
 * @property string $name
 * @property string $article
 * @property float $price
 * @property string|null $description
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Catalog\OfferFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalog\PropertyValue[] $properties
 * @property-read int|null $properties_count
 * @property int $amount
 * @method static \Illuminate\Database\Eloquent\Builder|Offer whereAmount($value)
 * @property-read \App\Models\Catalog\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|Offer withProperties()
 */
class Offer extends Model
{
    use HasFactory, CustomProperties;

    protected $fillable = ['article', 'price', 'amount'];

    public function properties() : MorphToMany
    {
        return $this->morphToMany(PropertyValue::class,'propertable');
    }

    public function scopeWithProperties($query)
    {
        $query->with('properties', function ($query) {
            $query->with('property_name');
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceFormat(): string
    {
        $price = floatval($this->price);
        return priceFormat($price);
    }

}
