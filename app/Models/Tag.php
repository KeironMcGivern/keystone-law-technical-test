<?php

namespace App\Models;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use Concerns\Tag\HasModelActions;
    use HasFactory;
    use SoftDeletes;
    use GeneratesUuid;
    use BindsOnUuid;

    protected $fillable = [
        'name',
    ];

    public function uuidColumn(): string
    {
        return 'guid';
    }

    public function links(): BelongsToMany
    {
        return $this->belongsToMany(
            PinnedLink::class,
            'pinned_link_tags',
            'tag_id',
            'pinned_link_id',
        )->withTimestamps();
    }
}
