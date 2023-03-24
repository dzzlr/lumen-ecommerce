<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

use App\Models\Shop;

class Product extends Model
{
    use HasFactory, HasUuid;

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    protected $fillable = [
        'shop_id', 'name', 'description', 'price', 'weight', 'stock', 'image'
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    // public function scopeFilter($query, array $filters)
    // {
    //     $query->when($filters['search'] ?? false, function($query, $search) {
    //         return $query->where('name','like','%'.$search.'%');
    //     });
    // }

    public function vendor()
    {
        return $this->belongsTo(Shop::class);
    }
}
