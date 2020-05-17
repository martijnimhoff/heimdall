<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Watcher;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class CreateWatcherMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'createWatcher',
        'description' => 'Create a watcher',
    ];

    public function type(): Type
    {
        return GraphQL::type('watcher');
    }

    public function args(): array
    {
        return [
            Watcher::COL_NAME         => [
                'name' => Watcher::COL_NAME,
                'type' => Type::nonnull(Type::string()),
            ],
            Watcher::COL_URL          => [
                'name' => Watcher::COL_URL,
                'type' => Type::nonnull(Type::string()),
            ],
            Watcher::COL_CSS_SELECTOR => [
                'name' => Watcher::COL_CSS_SELECTOR,
                'type' => Type::nonnull(Type::string()),
            ],
            Watcher::COL_IS_SCANNING  => [
                'name' => Watcher::COL_IS_SCANNING,
                'type' => Type::nonnull(Type::boolean()),
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            Watcher::COL_NAME         => 'required|max:255',
            Watcher::COL_URL          => 'required|max:255',
            Watcher::COL_CSS_SELECTOR => 'required|max:255',
            Watcher::COL_IS_SCANNING  => 'required|boolean',
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $watcher = new Watcher();

        $watcher->{Watcher::COL_USER_ID} = \Auth::id();
        $watcher->{Watcher::COL_NAME} = $args[Watcher::COL_NAME];
        $watcher->{Watcher::COL_URL} = $args[Watcher::COL_URL];
        $watcher->{Watcher::COL_CSS_SELECTOR} = $args[Watcher::COL_CSS_SELECTOR];
        $watcher->{Watcher::COL_IS_SCANNING} = $args[Watcher::COL_IS_SCANNING];

        $watcher->save();

        $watcher->loadCount([
            Watcher::REL_ENABLED_TRIGGERS,
            Watcher::REL_SCANS,
        ]);

        return $watcher;
    }
}
