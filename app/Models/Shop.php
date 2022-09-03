<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'name', 'description', 'address', 'phone', 'logo'
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
