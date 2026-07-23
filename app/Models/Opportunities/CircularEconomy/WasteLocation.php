<?php

namespace App\Models\Opportunities\CircularEconomy;

use Illuminate\Database\Eloquent\Model;

class WasteLocation extends Model
{
    protected $fillable = [
        'name',
        'name_sw',
        'description',
        'description_sw',
        'latitude',
        'longitude',
        'address',
        'type',
        'status',
        'capacity',
        'operational_hours',
        'accepts_recyclables',
        'accepts_hazardous',
        'phone',
        'email',
        'website',
        'image',
        'is_active',
        'operating_hours',
        'accepted_materials',
        'contact_phone',
        'contact_email',
    ];
    
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'capacity' => 'integer',
        'accepts_recyclables' => 'boolean',
        'accepts_hazardous' => 'boolean',
        'is_active' => 'boolean',
        'operating_hours' => 'json',
        'accepted_materials' => 'json',
    ];
} 