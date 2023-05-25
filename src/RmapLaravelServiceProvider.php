<?php

namespace MicahDShackelford\RmapLaravel;

use Illuminate\Database\Grammar;
use Illuminate\Database\Schema\Blueprint;
use MicahDShackelford\RmapLaravel\Commands\Clear;
use MicahDShackelford\RmapLaravel\Commands\Create;
use MicahDShackelford\RmapLaravel\Database\Schema\ExternalForeignKeyDefinition;
use MicahDShackelford\RmapLaravel\Exceptions\DropExternalForeignException;
use MicahDShackelford\RmapLaravel\Models\Relationship;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RmapLaravelServiceProvider extends PackageServiceProvider
{
    /**
     * https://github.com/spatie/laravel-package-tools
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('rmap-laravel')
            ->hasConfigFile()
            ->hasMigration('0000_00_00_0000 00_create_rmap_relationships_table')
            ->hasCommand(Clear::class)
            ->hasCommand(Create::class)
            ->runsMigrations();
    }

    public function boot()
    {
        parent::boot();

        // Create externalForeign

        Blueprint::macro($name = 'externalForeign', function (string $column) use ($name) {
            $this->commands[] = $command = new ExternalForeignKeyDefinition([
                'name' => $name,
                'column' => $column,
                'table' => $this->table,
            ]);

            return $command;
        });

        Grammar::macro('compileExternalForeign', function (Blueprint $blueprint, ExternalForeignKeyDefinition $definition) {
            Relationship::create([
                'origin_table' => $definition->table,
                'origin_column' => $definition->column,
                'target_connection' => $definition->connection,
                'target_schema' => $definition->schema,
                'target_table' => $definition->on,
                'target_column' => $definition->references,
            ]);
        });

        // Delete externalForeign

        Blueprint::macro($name = 'dropExternalForeign', function (string $column) use ($name) {
            $this->commands[] = $command = new ExternalForeignKeyDefinition([
                'name' => $name,
                'column' => $column,
                'table' => $this->table,
            ]);

            return $command;
        });

        Grammar::macro('compileDropExternalForeign', function (Blueprint $blueprint, ExternalForeignKeyDefinition $definition) {
            $query = Relationship::query()
                ->where('origin_table', $definition->table)
                ->where('origin_column', $definition->column);

            if ($connection = $definition?->connection) {
                $query = $query->where('target_connection', $connection);
            }

            if ($schema = $definition?->schema) {
                $query = $query->where('target_schema', $schema);
            }

            if ($table = $definition?->on) {
                $query = $query->where('target_table', $table);
            }

            if ($column = $definition?->references) {
                $query = $query->where('target_column', $column);
            }

            if ($query->delete() <= 0) {
                throw new DropExternalForeignException('Could not drop specified External Foreign Key.');
            }
        });
    }
}
