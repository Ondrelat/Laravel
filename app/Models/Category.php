<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];  

    public function getRouteKeyName(){
        return 'name';
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categorie(){
        return $this->belongsTo(Category::class);
    }

    public function categories(){
        return $this->hasMany(Category::class, "category_id", "id");
    }

    public function articles(){
        return $this->HasMany(Article::class);
    }

    public function article(){
        return $this->HasOne(Article::class);
    }

    public function allChildrenCategories()
    {
        return $this->categories()->with('allChildrenCategories');
    }
}
