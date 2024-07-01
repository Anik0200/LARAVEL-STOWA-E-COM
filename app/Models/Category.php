<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->whereNotNull('parent_id')->withTrashed();
    }

    public function Products()
    {
        return $this->belongsToMany(Product::class)->withPivot('product_id');
    }
}
