<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Trigger;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class TriggerQuery extends Query
{
    protected $attributes = [
        'name'        => 'trigger',
        'description' => 'Query a single trigger by id',
    ];

    public function type(): Type
    {
        return GraphQL::type('trigger');
    }

    public function args(): array
    {
        return [
            Trigger::COL_ID => [
                'name'  => 'id',
                'type'  => Type::int(),
                'rules' => 'required|exists:triggers,id',
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Trigger::findOrFail($args['id']);
    }
}
