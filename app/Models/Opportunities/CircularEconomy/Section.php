<?php

namespace App\Models\Opportunities\CircularEconomy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Section extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'page_id',
        'title',
        'identifier',
        'type',
        'order',
        'background_color',
        'text_color',
        'padding',
        'margin',
        'css_class',
        'css_style',
        'is_active',
        'meta_data',
        'meta',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'meta_data' => 'array',
        'meta' => 'json',
    ];
    
    /**
     * Get the page that owns the section.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
    
    /**
     * Get the contents for the section.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
    
    /**
     * Get the meta as an object for easy access
     */
    public function getMetaAttribute($value)
    {
        if (!$value) {
            return (object)[];
        }
        
        if (is_string($value)) {
            return (object)json_decode($value, true);
        }
        
        if (is_array($value)) {
            return (object)$value;
        }
        
        return $value; // Already an object
    }
    
    /**
     * Set the meta attribute to ensure it's properly stored
     */
    public function setMetaAttribute($value)
    {
        if (is_array($value) || is_object($value)) {
            $this->attributes['meta'] = json_encode($value);
            Log::debug('Section meta set from array/object', [
                'section_id' => $this->id,
                'value_type' => gettype($value),
                'encoded_value' => json_encode($value)
            ]);
        } else if (is_string($value)) {
            // Check if it's already valid JSON
            json_decode($value);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->attributes['meta'] = $value;
                Log::debug('Section meta set from JSON string', [
                    'section_id' => $this->id
                ]);
            } else {
                $this->attributes['meta'] = json_encode($value);
                Log::debug('Section meta set from non-JSON string', [
                    'section_id' => $this->id,
                    'encoded_value' => json_encode($value)
                ]);
            }
        } else {
            $this->attributes['meta'] = json_encode($value);
            Log::debug('Section meta set from other type', [
                'section_id' => $this->id,
                'value_type' => gettype($value),
                'encoded_value' => json_encode($value)
            ]);
        }
    }
    
    /**
     * Get the meta_data as an object for easy access
     */
    public function getMetaDataAttribute($value)
    {
        if (!$value) {
            return (object)[];
        }
        
        if (is_string($value)) {
            return (object)json_decode($value, true);
        }
        
        if (is_array($value)) {
            return (object)$value;
        }
        
        return $value; // Already an object
    }
    
    /**
     * Set the meta_data attribute to ensure it's properly stored
     */
    public function setMetaDataAttribute($value)
    {
        if (is_array($value) || is_object($value)) {
            $this->attributes['meta_data'] = json_encode($value);
            Log::debug('Section meta_data set from array/object', [
                'section_id' => $this->id,
                'value_type' => gettype($value),
                'encoded_value' => json_encode($value)
            ]);
        } else if (is_string($value)) {
            // Check if it's already valid JSON
            json_decode($value);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->attributes['meta_data'] = $value;
                Log::debug('Section meta_data set from JSON string', [
                    'section_id' => $this->id
                ]);
            } else {
                $this->attributes['meta_data'] = json_encode($value);
                Log::debug('Section meta_data set from non-JSON string', [
                    'section_id' => $this->id,
                    'encoded_value' => json_encode($value)
                ]);
            }
        } else {
            $this->attributes['meta_data'] = json_encode($value);
            Log::debug('Section meta_data set from other type', [
                'section_id' => $this->id,
                'value_type' => gettype($value),
                'encoded_value' => json_encode($value)
            ]);
        }
    }
    
    /**
     * Get the section CSS classes
     */
    public function getCssClasses(): string
    {
        $classes = ['section'];
        
        if (!empty($this->css_class)) {
            $classes[] = $this->css_class;
        }
        
        if ($this->type) {
            $classes[] = 'section-' . $this->type;
        }
        
        return implode(' ', $classes);
    }
    
    /**
     * Get the section CSS styles
     */
    public function getCssStyles(): string
    {
        $styles = [];
        
        if (!empty($this->background_color)) {
            $styles[] = 'background-color: ' . $this->background_color;
        }
        
        if (!empty($this->text_color)) {
            $styles[] = 'color: ' . $this->text_color;
        }
        
        if (!empty($this->padding)) {
            $styles[] = 'padding: ' . $this->padding;
        }
        
        if (!empty($this->margin)) {
            $styles[] = 'margin: ' . $this->margin;
        }
        
        if (!empty($this->css_style)) {
            $styles[] = $this->css_style;
        }
        
        return implode('; ', $styles);
    }
} 