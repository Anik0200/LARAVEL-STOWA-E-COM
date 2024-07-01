<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function Categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function productGalleries()
    {
        return $this->hasMany(ProductGallery::class)->withTrashed();
    }

    public function Inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
