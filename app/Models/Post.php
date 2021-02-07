<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    const CREATED_AT = 'published_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'description'
    ];

    protected $casts = [
        'published_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get the owner user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
