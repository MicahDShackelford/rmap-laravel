<?php

namespace MicahDShackelford\RmapLaravel\Database\Schema;

use Illuminate\Support\Fluent;

/**
 * @method ExternalForeignKeyDefinition connection(string $name) Specify the referenced connection
 * @method ExternalForeignKeyDefinition on(string $table) Specify the referenced table
 * @method ExternalForeignKeyDefinition references(string|array $columns) Specify the referenced column(s)
 * @method ExternalForeignKeyDefinition schema(string $name) Specify the referenced schema
 */
class ExternalForeignKeyDefinition extends Fluent
{
}
