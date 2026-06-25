<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    protected $fillable = ['title','category','device','description','image','image_url','active','order'];

    public function getImageSrcAttribute(): ?string
    {
        if ($this->image) return asset('storage/' . $this->image);
        return $this->image_url ?: null;
    }
}
