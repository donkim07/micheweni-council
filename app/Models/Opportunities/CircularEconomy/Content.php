<?php

namespace App\Models\Opportunities\CircularEconomy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Content extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'section_id',
        'title',
        'identifier',
        'type',
        'value',
        'template_identifier',
        'column_width',
        'margin',
        'padding',
        'order',
        'is_active',
        'meta',
        'title_sw',
        'page_id',
        'slug',
        'content',
        'content_sw',
        'meta_data',
        'is_featured',
        'form_builder_id',
        'css_class',
        'css_style'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'json',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'meta_data' => 'array',
    ];

    /**
     * Get the section that owns the content.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the page that owns the content.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the form builder associated with this content.
     */
    public function formBuilder(): BelongsTo
    {
        return $this->belongsTo(FormBuilder::class);
    }
    
    /**
     * Get the template associated with this content.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class, 'template_identifier', 'identifier');
    }

    /**
     * Get the translated title based on current locale.
     */
    public function getTranslatedTitleAttribute()
    {
        if (App::isLocale('sw') && !empty($this->title_sw)) {
            return $this->title_sw;
        }
        
        $translations = json_decode($this->title, true);
        if (is_array($translations) && isset($translations[app()->getLocale()])) {
            return $translations[app()->getLocale()];
        }
        return $this->title;
    }

    /**
     * Get the translated content based on current locale.
     */
    public function getTranslatedContentAttribute()
    {
        if (App::isLocale('sw') && !empty($this->content_sw)) {
            return $this->content_sw;
        }
        
        $translations = json_decode($this->content, true);
        if (is_array($translations) && isset($translations[app()->getLocale()])) {
            return $translations[app()->getLocale()];
        }
        return $this->content;
    }
    
    /**
     * Check if content is visible to a specific role
     */
    public function isVisibleToRole($role = 'guest'): bool
    {
        $visibilityRoles = $this->meta_data['visibility_roles'] ?? null;
        
        if (!$visibilityRoles) {
            return true; // Default to visible for all if not specified
        }
        
        // Convert string to array if stored as comma-separated string
        if (is_string($visibilityRoles)) {
            $visibilityRoles = explode(',', $visibilityRoles);
        }
        
        return in_array($role, $visibilityRoles);
    }
    
    /**
     * Get the CSS classes for this content component
     */
    public function getCssClasses(): string
    {
        $classes = [];
        
        // Add the component type as a class
        $classes[] = $this->type . '-component';
        
        // Add any custom CSS classes
        if (!empty($this->css_class)) {
            $classes[] = $this->css_class;
        }
        
        // Add template-specific class if defined
        if (!empty($this->template_identifier)) {
            $classes[] = $this->template_identifier;
            
            // If we have a template relationship, add its animation class
            if ($this->template && $this->template->animation) {
                $classes[] = $this->template->animation;
            }
            
            // Add hover effect if defined
            if ($this->template && $this->template->hover_effect) {
                $classes[] = $this->template->hover_effect;
            }
        }
        
        return implode(' ', $classes);
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
     * Set the meta attribute, ensuring proper JSON encoding
     */
    public function setMetaAttribute($value)
    {
        if (is_object($value)) {
            $value = (array)$value;
        }
        
        if (is_array($value)) {
            $this->attributes['meta'] = json_encode($value);
        } else if (is_string($value)) {
            // Check if already valid JSON
            json_decode($value);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->attributes['meta'] = $value;
            } else {
                $this->attributes['meta'] = json_encode($value);
            }
        } else {
            $this->attributes['meta'] = json_encode($value);
        }
    }
    
    /**
     * Get template settings for this content
     * 
     * @return array
     */
    public function getTemplateSettings(): array
    {
        $settings = [];
        
        // If we have a template, get its settings
        if ($this->template_identifier && $this->template) {
            $settings = $this->template->getDefaultSettings();
        }
        
        return $settings;
    }
    
    /**
     * Get template default content for this content
     * 
     * @return array
     */
    public function getTemplateDefaultContent(): array
    {
        $defaultContent = [];
        
        // If we have a template, get its default content
        if ($this->template_identifier && $this->template) {
            $defaultContent = $this->template->getDefaultContent();
        }
        
        return $defaultContent;
    }
    
    /**
     * Check if content uses a template of given category
     * 
     * @param string $category
     * @return bool
     */
    public function hasTemplateCategory(string $category): bool
    {
        if (!$this->template_identifier || !$this->template) {
            return false;
        }
        
        return $this->template->category === $category;
    }

    /**
     * Get the image URL for this content
     * 
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        $metaData = $this->meta_data;
        
        if (is_string($metaData)) {
            $metaData = json_decode($metaData, true);
        }
        
        $imagePath = $metaData['image'] ?? null;
        
        if (!$imagePath) {
            return asset('images/templates/placeholder.svg');
        }
        
        // Check if it's a full URL
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }
        
        // Check if path already includes 'images/' prefix
        if (str_starts_with($imagePath, 'images/')) {
            return asset($imagePath);
        }
        
        // Handle paths that start with a slash
        if (str_starts_with($imagePath, '/')) {
            $imagePath = ltrim($imagePath, '/');
        }
        
        // Return the full URL with the correct path
        return asset('images/' . $imagePath);
    }
}
