<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\TriggerType;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class TriggerTypesQuery extends Query
{
    protected $attributes = [
        'name' => 'triggerTypes',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('triggerType'));
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return TriggerType::all();
    }
}
