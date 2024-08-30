<?php

namespace App\Models;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function uuidColumn(): string
    {
        return 'guid';
    }
}
