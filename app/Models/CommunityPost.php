<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityPost extends Model
{
    protected $fillable = ['user_id', 'content', 'likes_count'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(CommunityComment::class, 'post_id');
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_post_likes', 'post_id', 'user_id')->withTimestamps();
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function topLevelComments(): HasMany
    {
        return $this->comments()->whereNull('parent_id');
    }

    public function topComments(): HasMany
    {
        return $this->comments()->whereNull('parent_id')->orderBy('created_at', 'asc')->limit(5);
    }

    public function remainingComments(): HasMany
    {
        return $this->comments()
            ->whereNull('parent_id')
            ->orderBy('created_at', 'asc')
            ->skip(5)  // Skip offset if there are more than 5 top comments
            ->take(PHP_INT_MAX); // Take all remaining comments
    }
}
