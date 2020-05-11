<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Trigger
 *
 * @property int $id
 * @property int $watcher_id
 * @property int $trigger_type_id
 * @property string $value_to_match
 * @property bool $is_enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TriggerType $triggerType
 * @property-read \App\Models\Watcher $watcher
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trigger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trigger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trigger query()
 * @mixin \Eloquent
 */
class Trigger extends Model
{
    const COL_ID = 'id';
    const COL_WATCHER_ID = 'watcher_id';
    const COL_TRIGGER_TYPE_ID = 'trigger_type_id';
    const COL_VALUE_TO_MATCH = 'value_to_match';
    const COL_IS_ENABLED = 'is_enabled';
    const COL_CREATED_AT = 'created_at';
    const COL_UPDATED_AT = 'updated_at';

    const REL_WATCHER = 'watcher';
    const REL_TRIGGER_TYPE = 'triggerType';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::COL_WATCHER_ID,
        self::COL_TRIGGER_TYPE_ID,
        self::COL_VALUE_TO_MATCH,
        self::COL_IS_ENABLED,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        self::COL_IS_ENABLED => 'boolean',
    ];

    /*******************************
     * Relationships
     *******************************/

    public function watcher(): BelongsTo
    {
        return $this->belongsTo(Watcher::class);
    }

    public function triggerType(): BelongsTo
    {
        return $this->belongsTo(TriggerType::class);
    }

    /*******************************
     * public utility methods
     *******************************/

    /**
     * @param Scan $scan
     * @return Hit|null
     */
    public function checkHit(Scan $scan): ?Hit
    {
        /** @var TriggerType $triggerType */
        $triggerType = $this->{Trigger::REL_TRIGGER_TYPE};

        if ($triggerType->match($this->{Trigger::COL_VALUE_TO_MATCH}, $scan->{Scan::COL_VALUE})) {
            return Hit::create([
                Hit::COL_SCAN_ID         => $scan->{Scan::COL_ID},
                Hit::COL_TRIGGER_ID      => $this->{self::COL_ID},
                Hit::COL_TRIGGER_TYPE_ID => $this->{self::COL_TRIGGER_TYPE_ID},
                Hit::COL_TRIGGER_VALUE   => $this->{self::COL_VALUE_TO_MATCH},
            ]);
        } else {
            return null;
        }
    }
}
