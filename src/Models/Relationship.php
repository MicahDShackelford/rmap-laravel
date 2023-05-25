<?php

namespace MicahDShackelford\RmapLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * MicahDShackelford\RmapLaravel\Models\Relationship
 *
 * @property int     $id
 * @property string  $origin_table
 * @property string  $origin_column
 * @property string  $target_connection
 * @property ?string $target_schema
 * @property string  $target_table
 * @property string  $target_column
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 */
class Relationship extends Model
{
    use HasFactory;

    public $guarded = [
        'id',
    ];

    protected $table = 'rmap_relationships';
}
