<?php

namespace App\Models\Opportunities\CircularEconomy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'identifier',
        'type',
        'description',
        'thumbnail',
        'settings',
        'default_content',
        'css_classes',
        'animation',
        'hover_effect',
        'category',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'array',
        'default_content' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the contents that use this template.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class, 'template_identifier', 'identifier');
    }

    /**
     * Get the default settings for this template.
     */
    public function getDefaultSettings(): array
    {
        return $this->settings ?: [];
    }

    /**
     * Get the default content for this template.
     */
    public function getDefaultContent(): array
    {
        return $this->default_content ?: [];
    }

    /**
     * Scope a query to only include active templates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by component type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeInCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get templates by category
     * 
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByCategory(string $category)
    {
        return self::where('category', $category)
                  ->where('is_active', true)
                  ->orderBy('name')
                  ->get();
    }

    /**
     * Get templates by type
     * 
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByType(string $type)
    {
        return self::where('type', $type)
                  ->where('is_active', true)
                  ->orderBy('name')
                  ->get();
    }

    /**
     * Get template by identifier
     * 
     * @param string $identifier
     * @return Template|null
     */
    public static function getByIdentifier(string $identifier)
    {
        return self::where('identifier', $identifier)->first();
    }

    /**
     * Get thumbnail image URL
     * 
     * @return string
     */
    public function getThumbnailUrl(): string
    {
        if (empty($this->thumbnail)) {
            return asset('images/templates/default.jpg');
        }
        
        return asset('storage/' . $this->thumbnail);
    }
} 