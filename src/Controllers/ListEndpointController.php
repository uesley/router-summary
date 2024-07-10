<?php

namespace Uesley\RouterSummary\Controllers;

use Uesley\RouterSummary\RouteMapper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

class ListEndpointController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'version' => '1.0',
            'routes' => collect(Route::getRoutes()->getRoutes())
                ->where('action.prefix', 'api')
                ->filter(fn ($route) => !empty($route->getName()))
                ->mapWithKeys(fn ($route) => [
                    RouteMapper::deduceMethod($route->getName()) => [
                        'uri' => $route->uri,
                        'description' => '',
                        'httpMethod' => head($route->methods),
                        'parameters' => str($route->uri)->explode('/')
                            ->mapWithKeys(function (?string $piece) {
                                if (!$piece || !str($piece)->contains('{')) {
                                    return [];
                                }
                                return [
                                    str($piece)->after('{')->before('}')->value => [
                                        'location' => 'uri',
                                        'description' => '',
                                        'type' => 'string',
                                        'required' => true,
                                    ],
                                ];
                            })
                            ->filter()
                            ->toArray()
                        ],
                ])
                ->toArray(),
        ]);
    }
}
