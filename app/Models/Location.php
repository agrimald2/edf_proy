<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['subregion_id', 'name', 'user_id'];

    /**
     * Get the user that owns the location.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the sub-region that owns the location.
     */
    public function subRegion()
    {
        return $this->belongsTo(SubRegion::class);
    }

    /**
     * Get the region through the sub-region.
     */
    public function region()
    {
        return $this->hasOneThrough(Region::class, SubRegion::class);
    }
}
