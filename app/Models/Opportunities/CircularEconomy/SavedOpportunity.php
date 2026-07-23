<?php

namespace App\Models\Opportunities\CircularEconomy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SavedOpportunity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'opportunity_id',
        'type',
        'notes'
    ];

    /**
     * Get the user that saved this opportunity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the opportunity content.
     */
    public function opportunity()
    {
        return $this->belongsTo(Content::class, 'opportunity_id');
    }
} 