<?php

namespace Ankur\Plugins\LazyIntercom;

class Admin
{
    const PLUGIN_SLUG = 'lazy_intercom';
    const PLUGIN_OPTION_GROUP = 'lazy_intercom';

    public function __construct()
    {
        register_activation_hook(plugin_basename(LIC_BASE_FILE), [$this, 'uponPluginActivation']);

        add_action('admin_init', [$this, 'registerPluginSettings']);

        add_action('admin_menu', [$this, 'addToSettingsMenu']);
    }

    public function uponPluginActivation()
    {
        if (get_option('lazy_intercom', false) === false) {
            update_option('lazy_intercom', $this->getDefaultOptions());
        }
    }

    private function getDefaultOptions()
    {
        return [
            'plugin_ver' => LIC_PLUGIN_VERSION,
            'enabled' => false,
            'app_id' => '',
            'secret_key' => '',
        ];
    }

    public function registerPluginSettings()
    {
        register_setting(self::PLUGIN_OPTION_GROUP, 'lazy_intercom', [$this, 'validateFormPost']);
    }

    public function addToSettingsMenu()
    {
        add_submenu_page(
            'options-general.php',
            'Lazy Intercom', //page title
            'Lazy Intercom',  //menu name
            'manage_options',
            self::PLUGIN_SLUG,
            [$this, 'loadOptionsPage']
        );
    }

    public function validateFormPost($in)
    {
        $out = [];
        $errors = [];

        //Always store plugin version to db
        $out['plugin_ver'] = LIC_PLUGIN_VERSION;

        if (empty($in['app_id'])) {
            $errors[] = 'App ID is required.';
        } else {
            $out['app_id'] = sanitize_text_field($in['app_id']);
        }

        $out['secret_key'] = sanitize_text_field($in['secret_key']);
        $out['enabled'] = absint($in['enabled']);

        // Show all form errors in a single notice
        if (!empty($errors)) {
            add_settings_error('lazy_intercom', 'lazy_intercom', implode('<br>', $errors));
        }

        return $out;
    }

    public function loadOptionsPage()
    {
        require plugin_dir_path(LIC_BASE_FILE).'views/settings.php';
    }

    private function getSafeOptions()
    {
        // Get fresh options from db
        $dbOptions = get_option('lazy_intercom');

        // Be fail safe, if not array then array_merge may fail
        if (!is_array($dbOptions)) {
            $dbOptions = [];
        }

        // If options not exists in db then init with defaults , also always append default options to existing options
        $dbOptions = empty($dbOptions) ? $this->getDefaultOptions() : array_merge($this->getDefaultOptions(),
            $dbOptions);

        return $dbOptions;
    }
}
