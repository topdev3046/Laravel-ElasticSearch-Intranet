<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InventoryHistory extends Model
{
    protected $guarded = []; //blacklist
    protected $fillable = ['inventory_id', 'user_id','inventory_category_id', 'inventory_size_id', 'value','mandant_id','text']; //whitelist
    
    protected $dates = ['created_at', 'updated_at'];
    
    public function item(){
        return $this->hasOne(Inventory::class,'id','inventory_id');
    }
     public function category(){
        return $this->hasOne(InventoryCategory::class,'id','inventory_category_id');
    }
    
    public function size(){
        return $this->hasOne(InventorySize::class,'id','inventory_size_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    
    public function getCreatedAtAttribute($value)
    {
        if(empty($value) || $value == null || $value == '')
            return null;
        else
            return Carbon::parse($value)->format('d.m.Y H:i:s');
    }
    
    public function getUpdatedAtAttribute($value)
    {
        if(empty($value) || $value == null || $value == '')
            return null;
        else
            return Carbon::parse($value)->format('d.m.Y H:i:s');
    }
}