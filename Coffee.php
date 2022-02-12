<?php

namespace App\Models;

class Coffee extends SuperModel
{
    protected $fillable = ['name', 
        'green_bean_id',
        'short_name', 
        'slug', 
        'coffee_desc', 
        'short_desc', 
        'blend', 
        'roast_type_id', 
        'price_1kg', 
        'price_250g', 
        'in_stock', 
        'stock_weight',
        'stock_kg_bags',
        'stock_g_bags',
        'last_roast_date',
        'new_bean',
        'new_bean_date',
        'sticker_id',
        'active', 
        'user_id'];
    
    protected $dates = ['last_roast_date', 'new_bean_date'];
    protected $casts = [
        'blend' => 'boolean',
        'in_stock' => 'boolean',
        'active' => 'boolean',
        'new_bean' => 'boolean'
    ];

    /**
     * Get the user that created/updated the coffee.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * The origin this coffee belongs to
     */
    /*public function origin()
    {
        return $this->belongsTo(Origin::class);
    }*/
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * Order items for the product
     */
    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function roast()
    {
        return $this->hasMany(Roast::class);
    }

    public function blendCoffees()
    {
        return $this->belongsToMany(Coffee::class, 'blend_coffee', 'blend_id', 'coffee_id')->withPivot('percent')->orderBy('name');
    }
    
    public function roastType()
    {
        return $this->belongsTo(RoastType::class);
    }
    
    public function sticker()
    {
        return $this->belongsTo(Sticker::class);
    }
    
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
    
    public function dispacth()
    {
        return $this->hasMany(Dispatch::class);
    }

    public function greenBean()
    {
        return $this->belongsTo(GreenBean::class);
    }
 
    /**
     * Gets a number and returns kg or g
     * @param type $weight
     */
    public function weight_text($weight)
    {
        if($weight == 0)
        {
            return $weight;
        } elseif($weight < 1000) {
            return $weight . 'g';
        } else {
            $weight = $weight / 1000;
            return $weight . 'kg';
        }   
    }
}