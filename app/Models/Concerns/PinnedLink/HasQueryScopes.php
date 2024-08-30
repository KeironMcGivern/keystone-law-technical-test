<?php

declare(strict_types=1);

namespace App\Models\Concerns\PinnedLink;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait HasQueryScopes
{
    public function scopeForTags(Builder $query, mixed $value): void
    {
        $query->when(
            filled($value),
            fn (Builder $query) => $query->whereJsonContains(
                'tags',
                is_array($value) ? $value : Arr::wrap($value)
            )
        );
    }
}
