<?php

namespace App\Models\Opportunities\CircularEconomy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Opportunities\CircularEconomy\FormBuilder;

class FormSubmission extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'form_builder_id',
        'user_id',
        'data',
        'latitude',
        'longitude',
        'address',
        'status',
        'meta_data',
        'ip_address',
        'user_agent',
    ];
    
    protected $casts = [
        'data' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
        'meta_data' => 'array',
    ];
    
    /**
     * Get the form that this submission belongs to.
     */
    public function form(): BelongsTo
    {
        return $this->belongsTo(FormBuilder::class, 'form_builder_id');
    }
    
    /**
     * Get the user that submitted this form.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 