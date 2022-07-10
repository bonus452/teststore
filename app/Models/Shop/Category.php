<?php

namespace App\Models\Shop;

use App\Interfaces\RowGetteble;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use stdClass;

/**
 * App\Models\Shop\Category
 *
 * @property int $id
 * @property string $title
 * @property string|null $ico
 * @property string|null $img
 * @property string $slug
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIco($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Category|null $parent
 * @property-read Collection $breadcrump
 * @method static Builder|Category whereHref($value)
 * @property string $url
 * @method static Builder|Category whereUrl($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $child
 * @property-read int|null $child_count
 */
class Category extends Model implements RowGetteble
{
    use HasFactory;

    private Collection $sub_categories;
    private int $count_products;
    protected $fillable = ['title', 'slug', 'url', 'img', 'parent_id'];

    public function getCountProducts(): int
    {
        return $this->count_products;
    }
    public function setCountProducts(int $count_products): Category
    {
        $this->count_products = $count_products;
        return $this;
    }

    public function getSubCategories(): Collection
    {
        return $this->sub_categories;
    }
    public function setSubCategories(Collection $sub_categories): void
    {
        $this->sub_categories = $sub_categories;
    }

    public function __construct(array $attributes = [])
    {
        $this->sub_categories = new Collection();
        parent::__construct($attributes);
    }

    public static function booted()
    {
        static::addGlobalScope('withoutroot', function (Builder $builder){
            return $builder->where('id', '!=', 1);
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function child(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function getUrlAttribute($value){
        return '/' . CATALOG_PATH . $value;
    }

    public function getAdminUrlAttribute(){
        return '/admin'  . $this->url;
    }

    public function getEditUrlAttribute(){
        return '/admin/catalog/category-edit/'.$this->id;
    }

}
