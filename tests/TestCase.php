<?php

namespace Tests;

use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Run a specific seeder before each test.
     *
     * @var string
     */
    protected $seeder = AdminSeeder::class;
}
