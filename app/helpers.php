<?php

if (!function_exists('redirectWithoutInertia')) {
    function redirectWithoutInertia(string $url)
    {
        // return response('', SymfonyResponse::HTTP_CONFLICT)->header('x-inertia-location', $url);
    }
}
