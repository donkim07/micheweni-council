<?php

namespace App\Models\Opportunities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Opportunities\Opportunity;

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
     * Get the opportunity.
     */
    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }
    
    /**
     * Check if an opportunity is saved by a user.
     *
     * @param int $userId
     * @param int $opportunityId
     * @return bool
     */
    public static function isSaved($userId, $opportunityId)
    {
        return self::where('user_id', $userId)
            ->where('opportunity_id', $opportunityId)
            ->exists();
    }
}
