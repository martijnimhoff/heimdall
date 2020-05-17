<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Trigger;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Builder;
use Rebing\GraphQL\Support\Query;

class TriggersQuery extends Query
{
    protected $attributes = [
        'name'        => 'triggers',
        'description' => 'A query',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('trigger'));
    }

    public function args(): array
    {
        return [
            'watcher_id' => [
                'name'  => 'watcher_id',
                'type'  => Type::int(),
                'rules' => 'nullable|exists:watchers,id',
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Trigger::when(isset($args['watcher_id']), function (Builder $query) use ($args) {
            $query->where(Trigger::COL_WATCHER_ID, $args['watcher_id']);
        })
            ->get();
    }
}
