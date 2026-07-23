<?php

namespace App\Models\Opportunities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Opportunity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'type',
        'category',
        'deadline',
        'location',
        'contact',
        'email',
        'phone',
        'website',
        'requirements',
        'benefits',
        'application_url',
        'application_process',
        'image',
        'is_active',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'requirements' => 'array',
        'benefits' => 'array',
        'deadline' => 'date',
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the display name for a category
     *
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        $categoryNames = [
            'circular-economy' => 'Circular Economy',
            'business' => 'Business',
            'agriculture' => 'Agriculture',
            'tourism' => 'Tourism & Culture'
        ];
        
        return $categoryNames[$this->category] ?? $this->category;
    }
    
    /**
     * Check if the opportunity is featured
     *
     * @return bool
     */
    public function getIsFeaturedAttribute()
    {
        return $this->type === 'featured_opportunity';
    }
    
    /**
     * Get the image URL attribute
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/templates/placeholder.svg');
        }
        
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        // Check if path already includes 'images/' prefix
        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }
        
        // Handle paths that are stored with just the subdirectory/filename format
        // e.g., "opportunities/filename.jpg"
        return asset('images/' . $this->image);
    }
    
    /**
     * Get opportunities by category
     * 
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByCategory($category)
    {
        return self::where('category', $category)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
