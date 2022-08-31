<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'weight',
        'stock',
        'image'
    ];

    // public function scopeFilter($query, array $filters)
    // {
    //     $query->when($filters['search'] ?? false, function($query, $search) {
    //         return $query->where('name','like','%'.$search.'%');
    //     });
    // }

    // public function vendor()
    // {
    //     return $this->belongsTo(Vendor::class);
    // }
}
