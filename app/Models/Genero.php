<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid as TraitsUuid;

class Genero extends Model
{
    use SoftDeletes, TraitsUuid;
    protected $fillable = ['name','is_active'];
    protected $dates = ['deleted_at','updated_at','created_at'];
    public $incrementing= false;
    protected $keyType ='String';
    protected $casts = ['is_active'=>'boolean'];
}
