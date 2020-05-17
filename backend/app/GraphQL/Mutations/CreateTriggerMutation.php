<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Trigger;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class CreateTriggerMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'createTrigger',
        'description' => 'Create a trigger',
    ];

    public function type(): Type
    {
        return GraphQL::type('trigger');
    }

    public function args(): array
    {
        return [
            Trigger::COL_WATCHER_ID      => [
                'name' => Trigger::COL_WATCHER_ID,
                'type' => Type::nonnull(Type::int()),
            ],
            Trigger::COL_TRIGGER_TYPE_ID => [
                'name' => Trigger::COL_TRIGGER_TYPE_ID,
                'type' => Type::nonnull(Type::int()),
            ],
            Trigger::COL_VALUE_TO_MATCH  => [
                'name' => Trigger::COL_VALUE_TO_MATCH,
                'type' => Type::nonnull(Type::string()),
            ],
            Trigger::COL_IS_ENABLED      => [
                'name' => Trigger::COL_IS_ENABLED,
                'type' => Type::nonnull(Type::boolean()),
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            Trigger::COL_WATCHER_ID      => 'required|exists:watchers,id',
            Trigger::COL_TRIGGER_TYPE_ID => 'required|exists:trigger_types,id',
            Trigger::COL_VALUE_TO_MATCH  => 'required|max:255',
            Trigger::COL_IS_ENABLED      => 'required|boolean',
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $trigger = new Trigger();

        $trigger->{Trigger::COL_WATCHER_ID} = $args[Trigger::COL_WATCHER_ID];
        $trigger->{Trigger::COL_TRIGGER_TYPE_ID} = $args[Trigger::COL_TRIGGER_TYPE_ID];
        $trigger->{Trigger::COL_VALUE_TO_MATCH} = $args[Trigger::COL_VALUE_TO_MATCH];
        $trigger->{Trigger::COL_IS_ENABLED} = $args[Trigger::COL_IS_ENABLED];

        $trigger->save();

        return $trigger;
    }
}
