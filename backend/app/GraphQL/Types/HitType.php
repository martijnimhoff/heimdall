<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Hit;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class HitType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Hit',
        'description' => 'Details about a hit',
        'model'       => Hit::class,
    ];

    public function fields(): array
    {
        return [
            Hit::COL_ID              => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Id of the hit',
            ],
            Hit::COL_SCAN_ID         => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The scan id of the hit',
            ],
            Hit::COL_TRIGGER_ID      => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The trigger id of the hit',
            ],
            Hit::COL_TRIGGER_TYPE_ID => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The trigger type id of the hit',
            ],
            Hit::COL_TRIGGER_VALUE   => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The trigger value of the hit',
            ],
            Hit::COL_CREATED_AT      => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Timestamp on which the hit was created',
            ],
            Hit::COL_UPDATED_AT      => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Timestamp on which the hit last updated',
            ],
        ];
    }
}
