<?php
/**
 * Plugin Name: Disable XML-RPC Abuse
 * Description: Removes XML-RPC methods used for password guessing and pingback abuse. Jetpack's signed methods are unaffected.
 */

add_filter('xmlrpc_methods', function (array $methods): array {
    unset(
        $methods['system.multicall'],
        $methods['pingback.ping'],
        $methods['pingback.extensions.getPingbacks']
    );

    return $methods;
});
