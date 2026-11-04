<?php
/**
 * Plugin Name: Hide User Enumeration
 * Description: Stops logged-out visitors discovering admin usernames via the REST users endpoint, author archives (?author=N) and the users sitemap.
 */

add_filter('rest_endpoints', function (array $endpoints): array {
    if (!is_user_logged_in()) {
        unset($endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }

    return $endpoints;
});

// Runs before redirect_canonical, so ?author=N no longer redirects to /author/{username}/
add_action('template_redirect', function (): void {
    if (is_author() && !is_user_logged_in()) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
    }
}, 1);

add_filter('wp_sitemaps_add_provider', function ($provider, string $name) {
    return $name === 'users' ? false : $provider;
}, 10, 2);
