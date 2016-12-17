<?php

/*
|--------------------------------------------------------------------------
| Detect Active Route
|--------------------------------------------------------------------------
|
| Compare given route with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function isActiveRoute($route, $output = "active")
{
    if (Route::currentRouteName() == $route) return $output;
}

/*
|--------------------------------------------------------------------------
| Detect Active Route Prefix
|--------------------------------------------------------------------------
|
| Compare given route prefix with current route prefix and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function isRoutePrefix($prefix, $output = "active")
{

    if (str_replace('/','',Request::route()->getPrefix()) == $prefix) return $output;
}

/*
|--------------------------------------------------------------------------
| Detect Active Routes
|--------------------------------------------------------------------------
|
| Compare given routes with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function areActiveRoutes(Array $routes, $output = "active")
{
    foreach ($routes as $route)
    {
        if (Route::currentRouteName() == $route) return $output;
    }
}

function formatVersion($number)
{
    $mod = ($number) % 200;
    $v1 = 0;
    $v2 = 0;
    if($mod == 0)
    {
        $v1 = $number / 200;
    }
    else {
        $v1 = $number < 200 ? 0 : substr(round($number / 200, 2, PHP_ROUND_HALF_DOWN),0,1);
        $v2 = ($number) % 200;
    }

    return $v1. '.' . $v2;
}