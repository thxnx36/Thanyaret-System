<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
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
        'author_name',
        'is_anonymous',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
    ];
    
    /**
     * Get the comments for the topic.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    
    /**
     * Get the displayed author name based on anonymity.
     */
    public function getDisplayAuthorAttribute(): string
    {
        if ($this->is_anonymous) {
            return 'Anonymous';
        }
        
        return $this->author_name ?? 'Anonymous';
    }
}
