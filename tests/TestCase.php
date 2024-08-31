<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Concerns\TestsInertiaProps;

abstract class TestCase extends BaseTestCase
{
    use TestsInertiaProps;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bootTestsInertiaProps();
    }
}
