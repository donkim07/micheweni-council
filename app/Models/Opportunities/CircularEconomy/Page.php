<?php

namespace App\Models\Opportunities\CircularEconomy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'description',
        'template',
        'parent_id',
        'is_active',
        'show_in_menu',
        'menu_order',
        'meta_data',
        'show_in_navigation',
        'navigation_order',
        'visibility_roles',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'show_in_menu' => 'boolean',
        'show_in_navigation' => 'boolean',
        'meta_data' => 'array',
        'visibility_roles' => 'array',
    ];
    
    /**
     * Get the parent page.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }
    
    /**
     * Get the child pages.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id');
    }
    
    /**
     * Get the contents for this page.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
    
    /**
     * Get the sections for this page.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }
    
    /**
     * Check if page is visible to a specific role
     */
    public function isVisibleToRole($role = 'guest'): bool
    {
        if (!$this->visibility_roles || empty($this->visibility_roles)) {
            return true; // Default to visible for all if not specified
        }
        
        return in_array($role, $this->visibility_roles);
    }
    
    /**
     * Get related pages based on parent-child relationship and/or similar content
     * 
     * @param int $limit Maximum number of related pages to return
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedPages($limit = 5)
    {
        // Start with siblings (pages that share the same parent)
        $relatedPages = self::where('parent_id', $this->parent_id)
            ->where('id', '!=', $this->id)
            ->where('is_active', true);
            
        // If not enough siblings, include children of the current page
        if ($relatedPages->count() < $limit) {
            $childPages = $this->children()
                ->where('is_active', true)
                ->limit($limit - $relatedPages->count());
                
            $relatedPages = $relatedPages->get()
                ->merge($childPages->get());
        } else {
            $relatedPages = $relatedPages->limit($limit)->get();
        }
        
        // If still not enough, add the parent page
        if ($relatedPages->count() < $limit && $this->parent) {
            $relatedPages->push($this->parent);
        }
        
        // If still not enough, add some recent/popular pages
        if ($relatedPages->count() < $limit) {
            $otherPages = self::where('id', '!=', $this->id)
                ->where('is_active', true)
                ->whereNotIn('id', $relatedPages->pluck('id')->toArray())
                ->orderBy('created_at', 'desc')
                ->limit($limit - $relatedPages->count())
                ->get();
                
            $relatedPages = $relatedPages->merge($otherPages);
        }
        
        return $relatedPages->take($limit);
    }
}
