<?php

namespace Tests\Fixtures;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $table = 'comments';

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
