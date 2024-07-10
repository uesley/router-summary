<?php

namespace Uesley\RouterSummary;

class RouteMapper
{
    public static function deduceMethod(string $route_name): string
    {
        $route_name = str($route_name);

        $action = $route_name->afterLast('.');
        $method_name = self::action($action);

        if (!$route_name->endsWith(['.index', '.show', '.update', '.store', '.destroy', '.delete'])) {
            return str($route_name->explode('.')
                ->map(fn ($str) => str($str)->studly())
                ->join(' '))
                ->camel();
        }

        if ($route_name->wordCount() > 2) {
            $paths = $route_name->beforeLast('.')
                ->explode('.')
                ->map(fn ($str) => str($str)->singular()->ucfirst())
                ->join('');

            $route_name = str("{$paths}." . $route_name->afterLast('.'));
        }

        $method_name .= (in_array($action->value, ['store', 'update', 'show', 'destroy']))
            ? $route_name->beforeLast('.')->singular()->studly()
            : $route_name->beforeLast('.')->plural()->studly();

        return $method_name;
    }

    private static function action(string $action): string
    {
        return ([
            'index' => 'list',
            'show' => 'get',
            'destroy' => 'delete',
        ])[$action] ?? $action;
    }
}
