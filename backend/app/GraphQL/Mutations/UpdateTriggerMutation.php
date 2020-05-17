<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Trigger;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class UpdateTriggerMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'updateTrigger',
        'description' => 'Update a trigger',
    ];

    public function type(): Type
    {
        return GraphQL::type('trigger');
    }

    public function args(): array
    {
        return [
            Trigger::COL_ID              => [
                'name' => Trigger::COL_ID,
                'type' => Type::nonNull(Type::int()),
            ],
            Trigger::COL_WATCHER_ID      => [
                'name' => Trigger::COL_WATCHER_ID,
                'type' => Type::int(),
            ],
            Trigger::COL_TRIGGER_TYPE_ID => [
                'name' => Trigger::COL_TRIGGER_TYPE_ID,
                'type' => Type::int(),
            ],
            Trigger::COL_VALUE_TO_MATCH  => [
                'name' => Trigger::COL_VALUE_TO_MATCH,
                'type' => Type::string(),
            ],
            Trigger::COL_IS_ENABLED      => [
                'name' => Trigger::COL_IS_ENABLED,
                'type' => Type::boolean(),
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            Trigger::COL_ID              => 'required|exists:triggers,id',
            Trigger::COL_WATCHER_ID      => 'nullable|exists:watchers,id',
            Trigger::COL_TRIGGER_TYPE_ID => 'nullable|exists:trigger_types,id',
            Trigger::COL_VALUE_TO_MATCH  => 'nullable|max:255',
            Trigger::COL_IS_ENABLED      => 'nullable|boolean',
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {

        $trigger = Trigger::find($args[Trigger::COL_ID]);

        if (!$trigger) {
            return null;
        }

        if (isset($args[Trigger::COL_WATCHER_ID])) {
            $trigger->{Trigger::COL_WATCHER_ID} = $args[Trigger::COL_WATCHER_ID];
        }
        if (isset($args[Trigger::COL_TRIGGER_TYPE_ID])) {
            $trigger->{Trigger::COL_TRIGGER_TYPE_ID} = $args[Trigger::COL_TRIGGER_TYPE_ID];
        }
        if (isset($args[Trigger::COL_VALUE_TO_MATCH])) {
            $trigger->{Trigger::COL_VALUE_TO_MATCH} = $args[Trigger::COL_VALUE_TO_MATCH];
        }
        if (isset($args[Trigger::COL_IS_ENABLED])) {
            $trigger->{Trigger::COL_IS_ENABLED} = $args[Trigger::COL_IS_ENABLED];
        }

        $trigger->save();

        return $trigger;
    }
}
