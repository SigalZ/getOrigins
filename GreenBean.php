<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GreenBean extends SuperModel
{
    use SoftDeletes;

    protected $table = 'green_beans';
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'name',
        'stock',
        'low_stock_warn'
    ];
    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }    
    
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class)->withPivot('bag_size');
    }

    public function coffees()
    {
        return $this->hasMany(Coffee::class);
    }

    public function activeCoffees()
    {
        return $this->coffees->where('active', 1)->get();
    }

     //Get soft deleted model
    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    /*public function resolveRouteBinding($value, $field = null)
    {
        // If no field was given, use the primary key
        if ($field === null) {
            $field = $this->getRouteKeyName();
        }

        // Apply where clause
        $query = $this->where($field, $value);
        
        // Conditionally remove the softdelete scope to allow seeing soft-deleted records
        $query->withoutGlobalScope(SoftDeletingScope::class);
       
        // Find the first record, or abort
        return $query->firstOrFail();
    }*/
}