<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Shop\PropertyName
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyName query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyName whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyName whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PropertyName extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function propertyValues(): HasMany
    {
        return $this->hasMany(PropertyValue::class);
    }

}
