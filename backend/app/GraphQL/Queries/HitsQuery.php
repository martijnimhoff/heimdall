<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Hit;
use App\Models\Scan;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Builder;
use Rebing\GraphQL\Support\Query;

class HitsQuery extends Query
{
    protected $attributes = [
        'name'        => 'hits',
        'description' => 'A query',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('hit'));
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
        return Hit::when(isset($args['watcher_id']), function (Builder $query) use ($args) {
            $query->whereHas(Hit::REL_SCAN, function (Builder $query) use ($args) {
                $query->where(Scan::COL_WATCHER_ID, $args['watcher_id']);
            });
        })
            ->get();
    }
}
