<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\TriggerType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Trigger[] $triggers
 * @property-read int|null $triggers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TriggerType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TriggerType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TriggerType query()
 * @mixin \Eloquent
 */
class TriggerType extends Model
{
    const COL_ID = 'id';
    const COL_NAME = 'name';
    const COL_CREATED_AT = 'created_at';
    const COL_UPDATED_AT = 'updated_at';

    const REL_TRIGGERS = 'triggers';

    const ID_IS = 1;
    const ID_IS_NOT = 2;
    const ID_CONTAINS = 3;
    const ID_DOES_NOT_CONTAIN = 4;

    /*******************************
     * Relationships
     *******************************/

    public function triggers(): HasMany
    {
        return $this->hasMany(Trigger::class);
    }

    /*******************************
     * public utility methods
     *******************************/

    /**
     * @param string $triggerValue
     * @param string $scanValue
     * @return bool
     */
    public function match(string $triggerValue, string $scanValue): bool
    {
        switch ($this->{self::COL_ID}) {
            case self::ID_IS:
                return trim($scanValue) === $triggerValue;
                break;
            case self::ID_IS_NOT:
                return trim($scanValue) !== $triggerValue;
                break;
            case self::ID_CONTAINS:
                return strpos($scanValue, $triggerValue) !== false;
                break;
            case self::ID_DOES_NOT_CONTAIN:
                return strpos($scanValue, $triggerValue) === false;
                break;
            default:
                throw new \Exception('Trigger type not implemented');
                break;
        }
    }
}
