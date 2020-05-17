<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Watcher;
use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class UpdateWatcherMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'Watcher',
        'description' => 'Update a watcher',
    ];

    public function type(): Type
    {
        return GraphQL::type('watcher');
    }

    public function args(): array
    {
        return [
            Watcher::COL_ID           => [
                'name' => Watcher::COL_ID,
                'type' => Type::nonNull(Type::int()),
            ],
            Watcher::COL_NAME         => [
                'name' => Watcher::COL_NAME,
                'type' => Type::string(),
            ],
            Watcher::COL_URL          => [
                'name' => Watcher::COL_URL,
                'type' => Type::string(),
            ],
            Watcher::COL_CSS_SELECTOR => [
                'name' => Watcher::COL_CSS_SELECTOR,
                'type' => Type::string(),
            ],
            Watcher::COL_IS_SCANNING  => [
                'name' => Watcher::COL_IS_SCANNING,
                'type' => Type::boolean(),
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            Watcher::COL_ID           => 'required',
            Watcher::COL_NAME         => 'nullable|max:255',
            Watcher::COL_URL          => 'nullable|max:255',
            Watcher::COL_CSS_SELECTOR => 'nullable|max:255',
            Watcher::COL_IS_SCANNING  => 'nullable|boolean',
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $watcher = Watcher::find($args[Watcher::COL_ID]);

        if (!$watcher) {
            return null;
        }

        if (isset($args[Watcher::COL_NAME])) {
            $watcher->{Watcher::COL_NAME} = $args[Watcher::COL_NAME];
        }
        if (isset($args[Watcher::COL_URL])) {
            $watcher->{Watcher::COL_URL} = $args[Watcher::COL_URL];
        }
        if (isset($args[Watcher::COL_CSS_SELECTOR])) {
            $watcher->{Watcher::COL_CSS_SELECTOR} = $args[Watcher::COL_CSS_SELECTOR];
        }
        if (isset($args[Watcher::COL_IS_SCANNING])) {
            $watcher->{Watcher::COL_IS_SCANNING} = $args[Watcher::COL_IS_SCANNING];
        }

        $watcher->save();

        $watcher->loadCount([
            Watcher::REL_ENABLED_TRIGGERS,
            Watcher::REL_SCANS,
        ]);

        return $watcher;
    }
}
