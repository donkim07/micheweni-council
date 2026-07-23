<?php

namespace App\Models\Opportunities\CircularEconomy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'title_sw',
        'description',
        'description_sw',
        'icon',
        'country_id',
        'year',
        'improvement',
        'previous_score',
        'current_score',
        'is_featured',
        'display_order'
    ];
    
    protected $casts = [
        'year' => 'integer',
        'improvement' => 'float',
        'previous_score' => 'float',
        'current_score' => 'float',
        'is_featured' => 'boolean',
        'display_order' => 'integer'
    ];
    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
} 