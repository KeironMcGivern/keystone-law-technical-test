<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    private function getVersion(): string
    {
        return Cache::remember('version-tag', now()->addWeek(), function () {
            if (! file_exists(public_path('release.txt'))) {
                return 'unversioned.dev';
            }

            $version = preg_replace(
                '/.+\\n(v[0-9]{1,9}\\.[0-9]{1,9}\\.[0-9]{1,9})/u',
                '$1',
                file_get_contents(public_path('release.txt'))
            );

            return trim($version);
        });
    }

    protected function hasAppContext(): array
    {
        return [
            'currentYear' => date('Y'),
            'app' => function () {
                return [
                    'env' => config('app.env'),
                    'version' => $this->getVersion(),
                    'token' => csrf_token(),
                ];
            },
        ];
    }

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(
            parent::share($request),
            $this->hasAppContext(),
        );
    }
}
