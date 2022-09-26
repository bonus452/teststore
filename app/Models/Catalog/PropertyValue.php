<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shop\PropertyValue
 *
 * @property int $propertable_id
 * @property string $propertable_type
 * @property int $property_name_id
 * @property int $value_id
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyValue wherePropertableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyValue wherePropertableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyValue wherePropertyNameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyValue whereValueId($value)
 * @mixin \Eloquent
 * @property int $id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Catalog\PropertyName|null $property_name
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyValue whereValue($value)
 * @method static \Database\Factories\Catalog\PropertyValueFactory factory(...$parameters)
 */
class PropertyValue extends Model
{
    use HasFactory;

    protected $fillable = ['value'];

    public function property_name(){
        return $this->belongsTo(PropertyName::class);
    }
}
