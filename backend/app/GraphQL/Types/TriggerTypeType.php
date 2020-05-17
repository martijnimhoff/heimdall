<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\TriggerType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TriggerTypeType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'TriggerType',
        'description' => 'Details about a trigger type',
        'model'       => TriggerType::class,
    ];

    public function fields(): array
    {
        return [
            TriggerType::COL_ID => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Id of the trigger type',
            ],
            TriggerType::COL_NAME => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Name of the trigger type',
            ],
            TriggerType::COL_CREATED_AT => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Timestamp on which the trigger type was created',
            ],
            TriggerType::COL_UPDATED_AT => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Timestamp on which the trigger type last updated',
            ]
        ];
    }
}
