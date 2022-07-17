<?php

namespace App\Models\Shop;

use App\Interfaces\RowGetteble;
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
 */
class Category extends Model implements RowGetteble
{
    use HasFactory;

    protected Collection $sub_categories;
    protected int $count_products;
    protected $fillable = ['title', 'slug', 'url', 'img', 'category_id'];

    protected $customProperties = [];

    public function getCustomProp($key){
        return $this->customProperties[$key] ?? null;
    }

    public function setCustomProp($key, $value){
        $this->customProperties[$key] = $value;
    }

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

    public function getImgAttribute($value){
        $result = $value instanceof UploadedFile
            ? $value
            : '/storage/'. $value;
        return $result;
    }

    public function getImgPathSystemAttribute(){
        $src = $this->getRawOriginal('img');
        if (!empty($src)){
            $is_windows = strripos(php_uname() ,'windows') !== false;
            $path = Storage::disk('public')->path($src);
            return $is_windows ?
                Str::replace("/", "\\",  $path) :
                $path;
        }else{
            return false;
        }

    }

    public function getResizedImage(){
        $image = Image::make($this->img);
    }

}
