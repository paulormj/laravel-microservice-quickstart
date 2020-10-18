<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid as TraitsUuid;

/**
 * App\Models\Genero
 *
 * @property string $id
 * @property string $name
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genero newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genero newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genero onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genero query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genero whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genero whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genero whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genero whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genero whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Genero whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genero withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Genero withoutTrashed()
 * @mixin \Eloquent
 */
class Genero extends Model
{
    use SoftDeletes, TraitsUuid;
    protected $fillable = ['name','is_active'];
    protected $dates = ['deleted_at','updated_at','created_at'];
    public $incrementing= false;
    protected $keyType ='String';
    protected $casts = ['is_active'=>'boolean'];
}
