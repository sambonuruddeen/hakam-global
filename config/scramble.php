<?php

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [
    /*
     * Your API path. By default, all routes starting with this path will be added to the docs.
     * If you need to change this behavior, you can add your custom routes resolver using `Scramble::routes()`.
     */
    'api_path' => 'api',

    /*
     * Your API domain. By default, app domain is used. This is also a part of the default API routes
     * matcher, so when implementing your own, make sure you use this config if needed.
     */
    'api_domain' => null,

    /*
     * The path where your OpenAPI specification will be exported.
     */
    'export_path' => 'api.json',

    'info' => [
        /*
         * API version.
         */
        'version' => env('API_VERSION', '0.0.1'),

        /*
         * Description rendered on the home page of the API documentation (`/docs/api`).
         */
        'description' => '',
    ],

    /*
     * Customize Stoplight Elements UI
     */
    'ui' => [
        /*
         * Define the title of the documentation's website. App name is used when this config is `null`.
         */
        'title' => null,

        /*
         * Define the theme of the documentation. Available options are `light`, `dark`, and `system`.
         */
        'theme' => 'light',

        /*
         * Hide the `Try It` feature. Enabled by default.
         */
        'hide_try_it' => false,

        /*
         * Hide the schemas in the Table of Contents. Enabled by default.
         */
        'hide_schemas' => false,

        /*
         * URL to an image that displays as a small square logo next to the title, above the table of contents.
         */
        'logo' => '',

        /*
         * Use to fetch the credential policy for the Try It feature. Options are: omit, include (default), and same-origin
         */
        'try_it_credentials_policy' => 'include',

        /*
         * There are three layouts for Elements:
         * - sidebar - (Elements default) Three-column design with a sidebar that can be resized.
         * - responsive - Like sidebar, except at small screen sizes it collapses the sidebar into a drawer that can be toggled open.
         * - stacked - Everything in a single column, making integrations with existing websites that have their own sidebar or other columns already.
         */
        'layout' => 'responsive',
    ],

    /*
     * The list of servers of the API. By default, when `null`, server URL will be created from
     * `scramble.api_path` and `scramble.api_domain` config variables. When providing an array, you
     * will need to specify the local server URL manually (if needed).
     *
     * Example of non-default config (final URLs are generated using Laravel `url` helper):
     *
     * ```php
     * 'servers' => [
     *     'Live' => 'api',
     *     'Prod' => 'https://scramble.dedoc.co/api',
     * ],
     * ```
     */
    'servers' => null,

    /**
     * Determines how Scramble stores the descriptions of enum cases.
     * Available options:
     * - 'description' – Case descriptions are stored as the enum schema's description using table formatting.
     * - 'extension' – Case descriptions are stored in the `x-enumDescriptions` enum schema extension.
     *
     *    @see https://redocly.com/docs-legacy/api-reference-docs/specification-extensions/x-enum-descriptions
     * - false - Case descriptions are ignored.
     */
    'enum_cases_description_strategy' => 'description',

    /**
     * Determines how Scramble stores the names of enum cases.
     * Available options:
     * - 'names' – Case names are stored in the `x-enumNames` enum schema extension.
     * - 'varnames' - Case names are stored in the `x-enum-varnames` enum schema extension.
     * - false - Case names are not stored.
     */
    'enum_cases_names_strategy' => false,

    /**
     * When Scramble encounters deep objects in query parameters, it flattens the parameters so the generated
     * OpenAPI document correctly describes the API. Flattening deep query parameters is relevant until
     * OpenAPI 3.2 is released and query string structure can be described properly.
     *
     * For example, this nested validation rule describes the object with `bar` property:
     * `['foo.bar' => ['required', 'int']]`.
     *
     * When `flatten_deep_query_parameters` is `true`, Scramble will document the parameter like so:
     * `{"name":"foo[bar]", "schema":{"type":"int"}, "required":true}`.
     *
     * When `flatten_deep_query_parameters` is `false`, Scramble will document the parameter like so:
     *  `{"name":"foo", "schema": {"type":"object", "properties":{"bar":{"type": "int"}}, "required": ["bar"]}, "required":true}`.
     */
    'flatten_deep_query_parameters' => true,

    'middleware' => [
        'web',
        RestrictedDocsAccess::class,
    ],

    'extensions' => [],

    'schemas' => class_exists(\Dedoc\Scramble\Support\Generator\Type::class)
        ? [
            // Generic API Response
            'ApiResponse' => \Dedoc\Scramble\Support\Generator\Type::object()
                ->properties([
                    'success' => \Dedoc\Scramble\Support\Generator\Type::boolean()->description('Indicates if request was successful'),
                    'message' => \Dedoc\Scramble\Support\Generator\Type::string()->description('Human readable message'),
                    'data'    => \Dedoc\Scramble\Support\Generator\Type::any()->nullable()->description('Response payload'),
                    'errors'  => \Dedoc\Scramble\Support\Generator\Type::any()->nullable()->description('Validation or error details'),
                    'meta'    => \Dedoc\Scramble\Support\Generator\Type::any()->nullable()->description('Optional metadata (e.g. pagination)'),
                ]),

            // Validation Error Response
            'ValidationError' => \Dedoc\Scramble\Support\Generator\Type::object()
                ->properties([
                    'success' => \Dedoc\Scramble\Support\Generator\Type::boolean()->example(false),
                    'message' => \Dedoc\Scramble\Support\Generator\Type::string()->example('Validation error'),
                    'data'    => \Dedoc\Scramble\Support\Generator\Type::null(),
                    'errors'  => \Dedoc\Scramble\Support\Generator\Type::object()->additionalProperties(
                        \Dedoc\Scramble\Support\Generator\Type::array(\Dedoc\Scramble\Support\Generator\Type::string())
                    )->description('Field-specific validation messages'),
                ]),

            // Paginated Response
            'PaginatedResponse' => \Dedoc\Scramble\Support\Generator\Type::object()
                ->properties([
                    'success' => \Dedoc\Scramble\Support\Generator\Type::boolean()->example(true),
                    'message' => \Dedoc\Scramble\Support\Generator\Type::string()->example('Data retrieved successfully'),
                    'data'    => \Dedoc\Scramble\Support\Generator\Type::array(\Dedoc\Scramble\Support\Generator\Type::any())->description('List of resources'),
                    'errors'  => \Dedoc\Scramble\Support\Generator\Type::null(),
                    'meta'    => \Dedoc\Scramble\Support\Generator\Type::object()->properties([
                        'page'     => \Dedoc\Scramble\Support\Generator\Type::integer()->example(1),
                        'per_page' => \Dedoc\Scramble\Support\Generator\Type::integer()->example(10),
                        'total'    => \Dedoc\Scramble\Support\Generator\Type::integer()->example(50),
                    ])->description('Pagination metadata'),
                ]),
        ]
        : [],

    // Hooks to modify responses globally - schema generation to wrap every response in ApiResponse
    'hooks' => class_exists(\Dedoc\Scramble\Support\Generator\Response::class)
        ? [
            'transformResponse' => function (\Dedoc\Scramble\Support\Generator\Response $response) {
                // Skip non-JSON responses
                if ($response->contentType !== 'application/json') {
                    return $response;
                }

                // If already documented with ApiResponse, don’t wrap again
                if ($response->schema && $response->schema->hasProperty('success')) {
                    return $response;
                }

                // Wrap response schema inside ApiResponse
                $original = $response->schema ?? \Dedoc\Scramble\Support\Generator\Type::any();

                $response->schema = \Dedoc\Scramble\Support\Generator\Type::ref('ApiResponse')
                    ->property('data', $original);

                return $response;
            },
        ]
        : [],

        
];
