<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'name', 'description', 'image', 'image_url', 'category', 'price', 'active', 'order', 'slug'
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });
    }

    public function getImageSrcAttribute()
    {
        if ($this->image) {
            return asset($this->image);
        }
        if ($this->image_url) {
            return $this->image_url;
        }
        return null;
    }

    public function getPriceFormattedAttribute()
    {
        if ($this->price) {
            return 'Desde $' . $this->price;
        }
        return null;
    }
}
