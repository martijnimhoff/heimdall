<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Scan;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ScanType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Scan',
        'description' => 'Details about a scan',
        'model'       => Scan::class,
    ];

    public function fields(): array
    {
        return [
            Scan::COL_ID         => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Id of the scan',
            ],
            Scan::COL_WATCHER_ID => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The watcher id of the scan',
            ],
            Scan::COL_VALUE      => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The value of the scan',
            ],
            Scan::COL_CREATED_AT => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Timestamp on which the scan was created',
            ],
            Scan::COL_UPDATED_AT => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Timestamp on which the scan last updated',
            ],
        ];
    }
}
