<?php

namespace App\Models\Opportunities\CircularEconomy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormBuilder extends Model
{
    use HasFactory;
    
    protected $table = 'form_builders';
    
    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon',
        'fields',
        'map_enabled',
        'map_icon',
        'map_color',
        'is_active',
    ];
    
    protected $casts = [
        'fields' => 'array',
        'map_enabled' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the form submissions for this form.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }
    
    /**
     * Set the fields attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setFieldsAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $value = $decoded;
            } else {
                $value = [];
            }
        }
        
        $this->attributes['fields'] = json_encode($value);
    }
    
    /**
     * Get the fields attribute.
     *
     * @param  string  $value
     * @return array
     */
    public function getFieldsAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }
} 