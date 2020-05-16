<?php

namespace App\GraphQL\Type;

use App\Models\Watcher;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class WatcherType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Watcher',
        'description' => 'Details about a watcher',
        'model'       => Watcher::class,
    ];

    public function fields(): array
    {
        return [
            Watcher::COL_ID           => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Id of the watcher',
            ],
            Watcher::COL_USER_ID      => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The user id of the watcher',
            ],
            Watcher::COL_NAME         => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Name of the watcher',
            ],
            Watcher::COL_URL          => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The url of the page, which the watcher is watching',
            ],
            Watcher::COL_CSS_SELECTOR => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The CSS selector of the element, which the watcher is watching',
            ],
            Watcher::COL_IS_SCANNING  => [
                'type'        => Type::nonNull(Type::boolean()),
                'description' => 'Whether the watcher is currently making scans',
            ],
            Watcher::COL_CREATED_AT   => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Timestamp on which the watcher was created',
            ],
            Watcher::COL_UPDATED_AT   => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Timestamp on which the watcher last updated',
            ],
            'enabled_triggers_count'  => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Count of how many enabled triggers this watcher has',
            ],
            'scans_count'             => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Count of how many scan this watcher has created',
            ],
        ];
    }
}
