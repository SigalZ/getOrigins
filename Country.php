<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Country extends SuperModel
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [ 'origin_id', 'name' ];
    protected $cascadeDeletes = ['greenBeans']; 
    protected $dates = ['deleted_at'];

    /**
     * origin
     */
    public function origin()
    {
       return $this->belongsTo(Origin::class);
    }

    public function greenBeans()
    {
        return $this->hasMany(GreenBean::class);
    }
}
