<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Trigger;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TriggerType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Trigger',
        'description' => 'Details about a trigger',
        'model'       => Trigger::class,
    ];

    public function fields(): array
    {
        return [
            Trigger::COL_ID              => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Id of the trigger',
            ],
            Trigger::COL_WATCHER_ID      => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The watcher id of the trigger',
            ],
            Trigger::COL_TRIGGER_TYPE_ID => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The trigger type id of the trigger',
            ],
            Trigger::COL_VALUE_TO_MATCH  => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The value for which the trigger is checking',
            ],
            Trigger::COL_IS_ENABLED      => [
                'type'        => Type::nonNull(Type::boolean()),
                'description' => 'Whether the trigger is enabled',
            ],
            Trigger::COL_CREATED_AT      => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Timestamp on which the trigger was created',
            ],
            Trigger::COL_UPDATED_AT      => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Timestamp on which the trigger last updated',
            ],

        ];
    }
}
