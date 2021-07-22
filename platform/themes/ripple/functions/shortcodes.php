<?php

app()->booted(function () {
    add_shortcode('google-map', __('Google map'), __('Custom map'), function ($shortCode) {
        return Theme::partial('short-codes.google-map', ['address' => $shortCode->content]);
    });

    shortcode()->setAdminConfig('google-map', Theme::partial('short-codes.google-map-admin-config'));

    add_shortcode('youtube-video', __('Youtube video'), __('Add youtube video'), function ($shortCode) {
        $url = rtrim($shortCode->content, '/');
        if (str_contains($url, 'watch?v=')) {
            $url = str_replace('watch?v=', 'embed/', $url);
        } else {
            $exploded = explode('/', $url);

            if (count($exploded) > 1) {
                $url = 'https://www.youtube.com/embed/' . Arr::last($exploded);
            }
        }

        return Theme::partial('short-codes.youtube-video', compact('url'));
    });

    shortcode()->setAdminConfig('youtube-video', Theme::partial('short-codes.youtube-video-admin-config'));

    if (is_plugin_active('blog')) {
        add_shortcode('featured-posts', __('Featured posts'), __('Featured posts'), function () {
            return Theme::partial('short-codes.featured-posts');
        });

        add_shortcode('recent-posts', __('Recent posts'), __('Recent posts'), function ($shortCode) {
            return Theme::partial('short-codes.recent-posts', ['title' => $shortCode->title]);
        });

        shortcode()->setAdminConfig('recent-posts', Theme::partial('short-codes.recent-posts-admin-config'));

        add_shortcode('featured-categories-posts', __('Featured categories posts'), __('Featured categories posts'),
            function ($shortCode) {
                return Theme::partial('short-codes.featured-categories-posts', ['title' => $shortCode->title]);
            });

        shortcode()->setAdminConfig('featured-categories-posts',
            Theme::partial('short-codes.featured-categories-posts-admin-config'));
    }

    if (is_plugin_active('gallery')) {
        add_shortcode('all-galleries', __('All Galleries'), __('All Galleries'), function ($shortCode) {
            return Theme::partial('short-codes.all-galleries', ['limit' => $shortCode->limit]);
        });

        shortcode()->setAdminConfig('all-galleries', Theme::partial('short-codes.all-galleries-admin-config'));
    }
});
