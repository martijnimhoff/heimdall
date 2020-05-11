<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Scan
 *
 * @property int $id
 * @property int $watcher_id
 * @property int|null $trigger_id
 * @property string $value_to_match
 * @property int|null $trigger_type_id
 * @property string $actual_value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Watcher $watcher
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Scan query()
 * @mixin \Eloquent
 * @property string $value
 */
class Scan extends Model
{
    const COL_ID = 'id';
    const COL_WATCHER_ID = 'watcher_id';
    const COL_VALUE = 'value';
    const COL_CREATED_AT = 'created_at';
    const COL_UPDATED_AT = 'updated_at';

    const REL_WATCHER = 'watcher';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::COL_WATCHER_ID,
        self::COL_VALUE,
    ];

    /*******************************
     * Relationships
     *******************************/

    public function watcher(): BelongsTo
    {
        return $this->belongsTo(Watcher::class);
    }
}
