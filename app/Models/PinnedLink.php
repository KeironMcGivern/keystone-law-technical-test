<?php

namespace App\Models;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PinnedLink extends Model
{
    use Concerns\PinnedLink\HasQueryScopes;
    use HasFactory;
    use SoftDeletes;
    use GeneratesUuid;
    use BindsOnUuid;

    protected $fillable = [
        'url',
        'title',
        'comments',
    ];

    protected $with = [
        'tags',
    ];

    // Always best practice to hide actual database values from the user, this package ensures that
    // all models set with it will have a unique identifier for all requests
    public function uuidColumn(): string
    {
        return 'guid';
    }

    // Though the tags could have been stored in a JSON column in the database, I felt it was best
    // to create its own model that we can then reuse elsewhere when needed
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'pinned_link_tags',
            'pinned_link_id',
            'tag_id',
        )->withTimestamps();
    }
}
