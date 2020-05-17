<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Trigger;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteTriggerMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'deleteTrigger',
        'description' => 'Delete a trigger',
    ];

    public function type(): Type
    {
        return GraphQL::type('trigger');
    }

    public function args(): array
    {
        return [
            Trigger::COL_ID => [
                'name' => Trigger::COL_ID,
                'type' => Type::nonNull(Type::int()),
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $trigger = Trigger::find($args[Trigger::COL_ID]);

        $id = $trigger->{Trigger::COL_ID};

        $trigger->delete();

        return [
            Trigger::COL_ID => $id,
        ];
    }
}
