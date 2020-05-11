<?php

namespace App\Models;

use App\Mail\HitNotify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Hit
 *
 * @property int $id
 * @property int $scan_id
 * @property int|null $trigger_id
 * @property int|null $trigger_type_id
 * @property string $trigger_value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Scan $scan
 * @property-read \App\Models\Trigger|null $trigger
 * @property-read \App\Models\TriggerType|null $triggerType
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hit query()
 * @mixin \Eloquent
 */
class Hit extends Model
{
    const COL_ID = 'id';
    const COL_SCAN_ID = 'scan_id';
    const COL_TRIGGER_ID = 'trigger_id';
    const COL_TRIGGER_TYPE_ID = 'trigger_type_id';
    const COL_TRIGGER_VALUE = 'trigger_value';
    const COL_CREATED_AT = 'created_at';
    const COL_UPDATED_AT = 'updated_at';

    const REL_SCAN = 'scan';
    const REL_TRIGGER = 'trigger';
    const REL_TRIGGER_TYPE = 'triggerType';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::COL_SCAN_ID,
        self::COL_TRIGGER_ID,
        self::COL_TRIGGER_TYPE_ID,
        self::COL_TRIGGER_VALUE,
    ];

    /*******************************
     * Relationships
     *******************************/

    public function scan(): BelongsTo
    {
        return $this->belongsTo(Scan::class);
    }

    public function trigger(): BelongsTo
    {
        return $this->belongsTo(Trigger::class);
    }

    public function triggerType(): BelongsTo
    {
        return $this->belongsTo(TriggerType::class);
    }

    /*******************************
     * public utility methods
     *******************************/

}
