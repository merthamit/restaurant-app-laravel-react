<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $appends = ['image_path'];
    protected $fillable = ['name', 'price', 'category_id', 'file_path'];
    protected $visible = ['id', 'name', 'price', 'category_id', 'image_path'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImagePathAttribute()
    {
        return asset($this->file_path);
    }
}
