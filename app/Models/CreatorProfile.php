<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreatorProfile extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'niche', 'location',
        'social_media_platform', 'social_media_link', 'follower_count',
        'engagement_rate', 'portfolio', 'price_per_post',
        'audience_details', 'availability',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
