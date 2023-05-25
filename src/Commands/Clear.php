<?php

namespace MicahDShackelford\RmapLaravel\Commands;

use Illuminate\Console\Command;
use MicahDShackelford\RmapLaravel\Models\Relationship;

class Clear extends Command
{
    public $signature = 'rmap:clear';

    public $description = 'Clear rmap external relationships';

    public function handle(): int
    {
        if ($this->confirm('Are you sure you wish to clear all the external relationship mappings?')) {
            Relationship::query()->delete();
            $this->info('Successfully cleared relationships!');
        } else {
            $this->info('Cancelled operation');
        }

        return self::SUCCESS;
    }
}
