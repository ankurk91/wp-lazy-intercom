<?php

namespace Ankur\Plugins\LazyIntercom;

class Frontend
{
    /** @var array $db */
    private $db;

    public function __construct()
    {
        $this->db = get_option('lazy_intercom');

        if ($this->shouldLoad()) {
            add_action('wp_footer', [$this, 'addHtml']);
            add_action('wp_enqueue_scripts', [$this, 'loadAssets'], 11);
        }
    }

    private function shouldLoad()
    {
        return $this->db && !empty($this->db['app_id']) && (bool) $this->db['enabled'];
    }

    public function addHtml()
    {
        require plugin_dir_path(LIC_BASE_FILE).'views/button.php';
    }

    public function loadAssets()
    {
        wp_enqueue_style('lazy-intercom', plugins_url('assets/frontend.css', LIC_BASE_FILE), [],
            LIC_PLUGIN_VERSION);

        wp_enqueue_script('lazy-intercom', plugins_url('assets/frontend.js', LIC_BASE_FILE), ['jquery'],
            LIC_PLUGIN_VERSION, true);

        wp_localize_script('lazy-intercom', 'intercomSettings', $this->getJsOptions());
    }

    private function getJsOptions()
    {
        $props = [
            'app_id' => $this->db['app_id'],
        ];

        if (is_user_logged_in()) {
            $props = array_merge($this->identityVerification(), $props);
        }

        return $props;
    }

    private function identityVerification()
    {
        $props = [];
        $user = wp_get_current_user();

        $props['email'] = $user->user_email;
        $props['name'] = $user->display_name;

        if (!empty($this->db['secret_key'])) {
            $props["user_hash"] = hash_hmac("sha256", $user->user_id, $this->db['secret_key']);
        }

        return $props;
    }
}
