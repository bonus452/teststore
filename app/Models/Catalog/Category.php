<?php

namespace App\Models\Catalog;

use App\Interfaces\RowGetteble;
use App\Traits\CustomProperties;
use App\Traits\ImagePath;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
 * @property-read mixed $admin_url
 * @property-read mixed $edit_url
 * @property-read mixed $img_src
 * @property-read mixed $path_system
 * @property-read mixed $img_path_system
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_keywords
 * @method static Builder|Category whereSeoDescription($value)
 * @method static Builder|Category whereSeoKeywords($value)
 * @method static Builder|Category whereSeoTitle($value)
 * @property string|null $image
 * @method static Builder|Category whereImage($value)
 */
class Category extends Model
{
    use HasFactory, CustomProperties, ImagePath;

    protected Collection $sub_categories;
    protected $fillable = [
        'title',
        'slug',
        'url',
        'image',
        'category_id',
        'seo_title',
        'seo_description',
        'seo_keywords'];

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

    public function getUrlAttribute($value): string
    {
        return '/' . CATALOG_PATH . $value;
    }

    public function getAdminUrl(): string
    {
        return '/admin'  . $this->url;
    }

    public function getEditUrl(): string
    {
        return '/admin/catalog/category-edit/'.$this->id;
    }


}
