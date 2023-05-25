<?php

namespace MicahDShackelford\RmapLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use MicahDShackelford\RmapLaravel\Models\Relationship;

class Create extends Command
{
    public $signature = 'rmap:create';

    public $description = 'Create a new rmap external relationship';

    public function handle(): int
    {
        $this->comment('Create External Relationship');

        if (! $input = $this->collectInput()) {
            return self::FAILURE;
        }

        if (Relationship::create($input)) {
            $this->info('Successfully created relationship!');
        }

        return self::SUCCESS;
    }

    private function collectInput(): ?array
    {
        $relationship = [];

        $relationship['origin_table'] = $originTable = $this->anticipate('Origin table', function (string $input) {
            return Arr::map(Schema::getAllTables(), fn ($table) => reset($table));
        });

        if (! Schema::hasTable($originTable)) {
            $this->error("Invalid table specified (doesn't exist): {$originTable}");

            return null;
        }

        $relationship['origin_column'] = $originColumn = $this->anticipate("Origin column on table ({$originTable})", function (string $input) use ($originTable) {
            return Schema::getColumnListing($originTable);
        });

        if (! Schema::hasColumn($originTable, $originColumn)) {
            $this->error("Invalid column specified (doesn't exist on $originTable): {$originColumn}");

            return null;
        }

        $relationship['target_connection'] = $this->ask('Target connection');
        $relationship['target_schema'] = $this->ask('Target schema', null);
        $relationship['target_table'] = $this->ask('Target table');
        $relationship['target_column'] = $this->ask('Target column');

        return $relationship;
    }
}
