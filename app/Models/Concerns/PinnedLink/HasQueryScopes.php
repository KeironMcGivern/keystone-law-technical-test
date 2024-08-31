<?php

declare(strict_types=1);

namespace App\Models\Concerns\PinnedLink;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

trait HasQueryScopes
{
    public function scopeForTags(Builder $query, mixed $value = null): void
    {
      $query->when(filled($value), function (Builder $query) use ($value) {
          $query->where(function ($query) use ($value) {
            foreach (Tag::getTagIds($value) as $tagId) {
              $query->whereHas('tags', function ($subQuery) use ($tagId) {
                return $subQuery->where('tags.id', $tagId);
              });
            }
          })->has('tags', '=', count($value));
      });
    }
}
