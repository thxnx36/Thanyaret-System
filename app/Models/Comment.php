<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'topic_id',
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
     * Get the topic that owns the comment.
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
    
    /**
     * Get the displayed author name based on anonymity.
     */
    public function getDisplayAuthorAttribute(): string
    {
        return $this->is_anonymous ? 'anonymous' : $this->author_name;
    }
}
