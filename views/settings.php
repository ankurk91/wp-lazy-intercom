<div class="wrap">
    <h2>Lazy Intercom Widget
        <small>(v<?php echo LIC_PLUGIN_VERSION; ?>)</small>
    </h2>

    <form action="<?php echo admin_url('options.php') ?>" method="post" id="lazy_intercom_form">
        <?php
        $options = $this->getSafeOptions();
        //wp inbuilt nonce field , etc
        settings_fields(self::PLUGIN_OPTION_GROUP);
        ?>

        <table class="form-table">
            <tr>
                <th scope="row">Enable</th>
                <td><label><input type="checkbox" name="lazy_intercom[enabled]"
                                  value="1" <?php checked($options['enabled'], 1) ?>>
                        Enable widget
                </td>
            </tr>
            <tr>
                <th scope="row">APP ID</th>
                <td><input type="text" size="25" name="lazy_intercom[app_id]"
                           value="<?php echo esc_attr($options['app_id']); ?>">
                    <a target="_blank"
                       href="https://www.intercom.com/help/faqs-and-troubleshooting/getting-set-up/where-can-i-find-my-workspace-id-app-id"><i
                            class="dashicons-before dashicons-external"></i></a>

                </td>
            </tr>
            <tr>
                <th scope="row">Identity verification secret</th>
                <td><input type="password" size="25" name="lazy_intercom[secret_key]"
                           value="<?php echo esc_attr($options['secret_key']); ?>">
                    <a target="_blank"
                       href="https://www.intercom.com/help/configure-intercom/staying-secure/enable-identity-verification-for-web-and-mobile"><i
                            class="dashicons-before dashicons-external"></i></a>

                </td>
            </tr>
        </table>
        <?php submit_button() ?>
    </form>
    <hr>
    <p>
        Developed with ♥ by- <a target="_blank" href="https://twitter.com/ankurk91">Ankur Kumar</a>
    </p>
</div>
