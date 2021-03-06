<?php

declare(strict_types=1);

return [

    // The prefix for routes
    'prefix'                 => 'graphql',

    // The routes to make GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Route
    //
    //
    'routes'                 => '{graphql_schema?}',

    // The controller to use in GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Controller and method
    //
    'controllers'            => \Rebing\GraphQL\GraphQLController::class . '@query',

    // Any middleware for the graphql route group
    'middleware'             => [
        'api',
        'auth:sanctum',
    ],

    // Additional route group attributes
    //
    // Example:
    //
    // 'route_group_attributes' => ['guard' => 'api']
    //
    'route_group_attributes' => [],

    // The name of the default schema used when no argument is provided
    // to GraphQL::schema() or when the route is used without the graphql_schema
    // parameter.
    'default_schema'         => 'default',

    'schemas'               => [
        'default' => [
            'query'      => [
                'hits'         => \App\GraphQL\Queries\HitsQuery::class,
                'scans'        => \App\GraphQL\Queries\ScansQuery::class,
                'trigger'      => \App\GraphQL\Queries\TriggerQuery::class,
                'triggers'     => \App\GraphQL\Queries\TriggersQuery::class,
                'triggerTypes' => \App\GraphQL\Queries\TriggerTypesQuery::class,
                'watcher'      => \App\GraphQL\Queries\WatcherQuery::class,
                'watchers'     => \App\GraphQL\Queries\WatchersQuery::class,
            ],
            'mutation'   => [
                'createWatcher' => \App\GraphQL\Mutations\CreateWatcherMutation::class,
                'updateWatcher' => \App\GraphQL\Mutations\UpdateWatcherMutation::class,
                'createTrigger' => \App\GraphQL\Mutations\CreateTriggerMutation::class,
                'updateTrigger' => \App\GraphQL\Mutations\UpdateTriggerMutation::class,
                'deleteTrigger' => \App\GraphQL\Mutations\DeleteTriggerMutation::class,
            ],
            'middleware' => [],
            'method'     => [
                'get',
                'post',
            ],
        ],
    ],

    // The types available in the application. You can then access it from the
    // facade like this: GraphQL::type('user')
    //
    'types'                 => [
        'watcher'     => \App\GraphQL\Types\WatcherType::class,
        'hit'         => \App\GraphQL\Types\HitType::class,
        'trigger'     => \App\GraphQL\Types\TriggerType::class,
        'triggerType' => \App\GraphQL\Types\TriggerTypeType::class,
        'scan'        => \App\GraphQL\Types\ScanType::class,
    ],

    // The types will be loaded on demand. Default is to load all types on each request
    // Can increase performance on schemes with many types
    // Presupposes the config type key to match the type class name property
    'lazyload_types'        => false,

    // This callable will be passed the Error object for each errors GraphQL catch.
    // The method should return an array representing the error.
    // Typically:
    // [
    //     'message' => '',
    //     'locations' => []
    // ]
    'error_formatter'       => [
        '\Rebing\GraphQL\GraphQL',
        'formatError',
    ],

    /*
     * Custom Error Handling
     *
     * Expected handler signature is: function (array $errors, callable $formatter): array
     *
     * The default handler will pass exceptions to laravel Error Handling mechanism
     */
    'errors_handler'        => [
        '\Rebing\GraphQL\GraphQL',
        'handleErrors',
    ],

    // You can set the key, which will be used to retrieve the dynamic variables
    'params_key'            => 'variables',

    /*
     * Options to limit the query complexity and depth. See the doc
     * @ https://webonyx.github.io/graphql-php/security
     * for details. Disabled by default.
     */
    'security'              => [
        'query_max_complexity'  => null,
        'query_max_depth'       => null,
        'disable_introspection' => false,
    ],

    /*
     * You can define your own pagination type.
     * Reference \Rebing\GraphQL\Support\PaginationType::class
     */
    'pagination_type'       => \Rebing\GraphQL\Support\PaginationType::class,

    /*
     * Config for GraphiQL (see (https://github.com/graphql/graphiql).
     */
    'graphiql'              => [
        'prefix'     => '/graphiql',
        'controller' => \Rebing\GraphQL\GraphQLController::class . '@graphiql',
        'middleware' => [],
        'view'       => 'graphql::graphiql',
        'display'    => env('ENABLE_GRAPHIQL', true),
    ],

    /*
     * Overrides the default field resolver
     * See http://webonyx.github.io/graphql-php/data-fetching/#default-field-resolver
     *
     * Example:
     *
     * ```php
     * 'defaultFieldResolver' => function ($root, $args, $context, $info) {
     * },
     * ```
     * or
     * ```php
     * 'defaultFieldResolver' => [SomeKlass::class, 'someMethod'],
     * ```
     */
    'defaultFieldResolver'  => null,

    /*
     * Any headers that will be added to the response returned by the default controller
     */
    'headers'               => [],

    /*
     * Any JSON encoding options when returning a response from the default controller
     * See http://php.net/manual/function.json-encode.php for the full list of options
     */
    'json_encoding_options' => 0,
];
