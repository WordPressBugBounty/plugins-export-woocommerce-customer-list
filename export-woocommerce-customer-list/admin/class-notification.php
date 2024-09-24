<?php

class pisol_ewcl_free_notifications{
    function __construct(){
        add_action('admin_notices', array($this, 'guestCheckoutNotification'));
    }

    function guestCheckoutNotification(){
        if(!isset($_GET['page']) || $_GET['page'] != 'pisol-ewcl-notification' || get_option('woocommerce_enable_guest_checkout') != 'yes') return;
        ?>
        <div class="notice notice-warning">
        <h3>Guest checkout is enabled on your site, so the customer that used guest checkout there details will be under <a href="<?php echo esc_url(admin_url('admin.php?page=pisol-ewcl-notification&tab=guest')); ?>">Export Guest Customer</a> tab</h3>
        </div>
        <?php
    }
}

new pisol_ewcl_free_notifications();