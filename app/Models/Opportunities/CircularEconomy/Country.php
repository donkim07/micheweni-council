<?php

namespace App\Models\Opportunities\CircularEconomy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'code',
        'flag',
        'circularity_score',
        'region',
        'waste_per_capita',
        'circular_material_use_rate',
        'waste_properly_treated',
        'is_featured',
        'ranking',
        'is_local'
    ];
    
    protected $casts = [
        'circularity_score' => 'float',
        'waste_per_capita' => 'float',
        'circular_material_use_rate' => 'float',
        'waste_properly_treated' => 'float',
        'is_featured' => 'boolean',
        'ranking' => 'integer',
        'is_local' => 'boolean'
    ];
    
    /**
     * Get the achievements associated with the country.
     */
    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
}
