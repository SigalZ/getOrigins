<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Origin extends SuperModel
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [ 'name', 'slug', 'user_id' ];
    protected $cascadeDeletes = ['countries'];
    protected $dates = ['deleted_at'];

    /**
     * Countries belong to this origin
     */
    public function countries()
    {
       return $this->hasMany(Country::class);
    }

    public function greenBeans()
    {
        return $this->hasManyThrough(GreenBean::class, Country::class);
    }
    
    public function deployments()
    {
        return $this->hasManyThrough(Deployment::class, Environment::class);
    }

    public function scopeHasCoffees($query)
    {
        return $query->select('origins.name', 'origins.id')
                ->join('countries', 'origins.id', '=', 'origin_id')
                ->join('green_beans', 'countries.id', '=', 'country_id')
                ->leftJoin('coffees', 'green_bean_id', '=', 'green_beans.id')
                ->where('coffees.active', 1)
                ->orderBy('origins.name')
                ->groupBy('origins.name', 'origins.id');
    }
}
