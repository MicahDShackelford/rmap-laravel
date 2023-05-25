<?php

namespace MicahDShackelford\RmapLaravel\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use MicahDShackelford\RmapLaravel\RmapLaravelServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'MicahDShackelford\\RmapLaravel\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            RmapLaravelServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/0000_00_00_000000_create_rmap_relationships_table.php';
        $migration->up();
    }
}
