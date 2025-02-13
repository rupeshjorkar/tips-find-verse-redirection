<?php

class My_Custom_Plugin_Updater {
    private $plugin_slug;
    private $plugin_version;
    private $update_url;

    public function __construct($plugin_slug, $plugin_version, $update_url) {
        $this->plugin_slug = $plugin_slug;
        $this->plugin_version = $plugin_version;
        $this->update_url = $update_url;

        add_filter('pre_set_site_transient_update_plugins', [$this, 'check_for_update']);
        add_filter('plugins_api', [$this, 'plugin_update_info'], 10, 3);
    }

    public function check_for_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        // Retrieve update info from the server
        $response = wp_remote_get($this->update_url . '?action=get_version');
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return $transient;
        }

        $update_data = json_decode(wp_remote_retrieve_body($response));
        if ($update_data && version_compare($this->plugin_version, $update_data->new_version, '<')) {
            $transient->response[$this->plugin_slug] = (object) [
                'slug'        => $this->plugin_slug,
                'new_version' => $update_data->new_version,
                'url'         => $update_data->homepage,
                'package'     => $update_data->download_url,
            ];
        }

        return $transient;
    }

    public function plugin_update_info($result, $action, $args) {
        if ($action !== 'plugin_information' || $args->slug !== $this->plugin_slug) {
            return $result;
        }

        // Retrieve detailed plugin information
        $response = wp_remote_get($this->update_url . '?action=get_info');
        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return $result;
        }

        $plugin_info = json_decode(wp_remote_retrieve_body($response));
        return (object) [
            'name'        => $plugin_info->name,
            'slug'        => $this->plugin_slug,
            'version'     => $plugin_info->version,
            'author'      => $plugin_info->author,
            'homepage'    => $plugin_info->homepage,
            'download_link' => $plugin_info->download_url,
            'sections'    => [
                'description' => $plugin_info->description,
                'changelog'   => $plugin_info->changelog,
            ],
        ];
    }
}

// Initialize the updater
new My_Custom_Plugin_Updater(
    TIPS_FIND_VERSE_BASENAME, // Plugin slug
    TIPS_FIND_VERSE_VERSION, // Current version
    'https://cmetricbeta.c-metric.com/bible-tips-plugin/tips-find-verse.json' // Update server URL
);
