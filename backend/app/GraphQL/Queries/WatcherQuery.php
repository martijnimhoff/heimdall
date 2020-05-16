<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Watcher;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class WatcherQuery extends Query
{
    protected $attributes = [
        'name'        => 'watcher',
        'description' => 'Query a single watcher by id',
    ];

    public function type(): Type
    {
        return GraphQL::type('watcher');
    }

    public function args(): array
    {
        return [
            Watcher::COL_ID => [
                'name'  => 'id',
                'type'  => Type::int(),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Watcher::findOrFail($args['id'])
            ->loadCount([
                Watcher::REL_ENABLED_TRIGGERS,
                Watcher::REL_SCANS,
            ]);
    }
}
