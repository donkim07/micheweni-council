<?php

namespace App\Models\Opportunities\CircularEconomy;
use App\Models\Opportunities\CircularEconomy\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class News extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'title_sw',
        'slug',
        'excerpt',
        'excerpt_sw',
        'content',
        'content_sw',
        'featured_image',
        'category_id',
        'author_id',
        'is_published',
        'published_at',
        'meta_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'meta_data' => 'array',
    ];

    /**
     * Get the category that owns the news article.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the author of the news article.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the translated title based on current locale.
     */
    public function getTranslatedTitleAttribute()
    {
        $locale = App::getLocale();
        
        if ($locale === 'sw' && !empty($this->title_sw)) {
            return $this->title_sw;
        }
        
        return $this->title;
    }

    /**
     * Get the translated excerpt based on current locale.
     */
    public function getTranslatedExcerptAttribute()
    {
        $locale = App::getLocale();
        
        if ($locale === 'sw' && !empty($this->excerpt_sw)) {
            return $this->excerpt_sw;
        }
        
        return $this->excerpt;
    }

    /**
     * Get the translated content based on current locale.
     */
    public function getTranslatedContentAttribute()
    {
        $locale = App::getLocale();
        
        if ($locale === 'sw' && !empty($this->content_sw)) {
            return $this->content_sw;
        }
        
        return $this->content;
    }
}
