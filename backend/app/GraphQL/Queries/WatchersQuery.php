<?php

namespace App\GraphQL\Queries;

use App\Models\Watcher;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class WatchersQuery extends Query
{
    protected $attributes = [
        'name' => 'watchers',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('watcher'));
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Watcher::orderBy(Watcher::COL_CREATED_AT, 'DESC')
            ->withCount([
                Watcher::REL_ENABLED_TRIGGERS,
                Watcher::REL_SCANS,
            ])
            ->get();
    }
}
