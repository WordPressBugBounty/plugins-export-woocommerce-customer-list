<?php

class Pi_Ewcl_Menu{

    public $plugin_name;
    public $version;
    public $menu;
    
    function __construct($plugin_name , $version){
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action( 'admin_menu', array($this,'plugin_menu') );
        add_action($this->plugin_name.'_promotion', array($this,'promotion'));
    }

    function plugin_menu(){
        
        $this->menu = add_submenu_page(
            'tools.php',
            __( 'Export Customer','pisol-ewcl'),
            __( 'Export Customer','pisol-ewcl'),
            'manage_options',
            'pisol-ewcl-notification',
            array($this, 'menu_option_page')
        );

        add_action("load-".$this->menu, array($this,"bootstrap_style"));
 
    }

    public function bootstrap_style() {
        wp_enqueue_style( 'jquery-ui',  plugin_dir_url( __FILE__ ).'css/jquery-ui.css');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pisol-ewcl-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name."_bootstrap", plugin_dir_url( __FILE__ ) . 'css/bootstrap.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'select2', WC()->plugin_url() . '/assets/css/select2.css');
        wp_enqueue_script( 'selectWoo', WC()->plugin_url() . '/assets/js/selectWoo/selectWoo.full.min.js', array( 'jquery' ), '1.0.4' );

        $js= '
        jQuery(function($){
            if(typeof $.fn.selectWoo == "undefined") return;

            $("#pi_ewcl_order_status, #pi_ewcl_user_role").selectWoo({
                placeholder: \'Select Order Status\'
            });
        });
        ';
        wp_add_inline_script('selectWoo', $js, 'after');
	}

    function menu_option_page(){
        if(function_exists('settings_errors')){
            settings_errors();
        }
        ?>
        <div class="bootstrap-wrapper">
        <div class="pisol-container mt-2">
            <div class="pisol-row">
                    <div class="col-12">
                        <div class='bg-dark'>
                        <div class="pisol-row">
                            <div class="col-12 col-sm-2 py-2">
                                    <a href="https://www.piwebsolution.com/" target="_blank"><img class="img-fluid ml-2" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/pi-web-solution.png"></a>
                            </div>
                            <div class="col-12 col-sm-10 d-flex small text-center pisol-top-menu">
                                <?php do_action($this->plugin_name.'_tab'); ?>
                                <!--<a class=" px-3 text-light d-flex align-items-center  border-left border-right  bg-info " href="https://www.piwebsolution.com/documentation-for-live-sales-notifications-for-woocommerce-plugin/">
                                    Documentation
                                </a>-->
                            </div>
                        </div>
                        </div>
                    </div>
            </div>
            <?php do_action($this->plugin_name.'_tab_sub_menu'); ?>
            <div class="pisol-row">
                <div class="col-12">
                <div class="bg-light border pl-3 pr-3 pb-3 pt-0">
                    <div class="pisol-row">
                        <div class="col">
                        <?php do_action($this->plugin_name.'_tab_content'); ?>
                        </div>
                        <?php do_action($this->plugin_name.'_promotion'); ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </div>
        <?php
    }

    function promotion(){
        if(isset($_GET['tab']) && $_GET['tab'] == 'other_plugins') return;
        ?>
         <div class="col-12 col-sm-12 col-md-4 pt-3">
                <div class="bg-dark text-light text-center mb-3">
                    <a href="<?php echo esc_url(PI_EWCL_BUY_URL); ?>" target="_blank">
                    <?php  new pisol_promotion("pi_ewcl_installation_date"); ?>
                    </a>
                </div>

            <div class="pi-shadow">
                <div class="pisol-row justify-content-center">
                    <div class="col-md-9 col-sm-12">
                        <div class="p-2 text-center">
                            <img class="img-fluid" src="<?php echo esc_url(plugin_dir_url( __FILE__ )); ?>img/bg.svg">
                        </div>
                    </div>
                </div>
                <div class="text-center py-2">
                    <a class="btn btn-success btn-sm text-uppercase mb-2 " href="<?php echo esc_url(PI_EWCL_BUY_URL); ?>&utm_ref=top_link" target="_blank">Buy Now !!</a>
                </div>
                <h2 id="pi-banner-tagline" class="mb-0">Get Pro for <?php echo esc_html(PI_EWCL_PRICE); ?> Only</h2>
                <div class="inside">
                    <ul class="pisol-pro-feature-list">
					    <li class="border-top font-weight-light h6"><strong  class="text-primary">Export gust customer</strong> list</li>
                        <li class="border-top font-weight-light h6">Filter guest customer list based on the <strong  class="text-primary">Order Status</strong></li>
                        <li class="border-top font-weight-light h6">Modify the <strong class="text-primary">label of the CSV columns</strong> (and save them so you can directly export csv in your external software)</li>
                        <li class="border-top font-weight-light h6">Download users based on <strong  class="text-primary">registration date</strong></li>
                        <li class="border-top font-weight-light h6">Download customers based on registration done between a certain <strong  class="text-primary">date range</strong></li>
                        <li class="border-top font-weight-light h6">Get customer list in an email attachment, on set frequency <strong  class="text-primary">(Hourly, Twice Daily, Daily, Weekly)</strong></li>
                        <li class="border-top font-weight-light h6">Get the list of users <strong  class="text-primary">registered in the set interval</strong> in an email (Hourly, Daily, Twice Daily, Weekly)</li>
                        <li class="border-top font-weight-light h6">Download <strong  class="text-primary">extra user-related date</strong> (Extra date is one that is added by plugin other than WooCommerce or WordPress)</li>
                        <li class="border-top font-weight-light h6">Select if you want to receive Registered customer, Guest customer or both customer <strong  class="text-primary">record in email</strong></li>
                        <li class="border-top font-weight-light h6">Adjust <strong  class="text-primary">download speed</strong></li>
                    </ul>
                    <div class="text-center pb-3 pt-2">
                    <a class="btn btn-primary btn-lg" href="<?php echo esc_url(PI_EWCL_BUY_URL); ?>&utm_ref=bottom_link" target="_blank">Click to Buy Now</a>
                    </div>
                </div>
               </div>

            </div>
        <?php
    }

    function isWeekend() {
        return (date('N', strtotime(date('Y/m/d'))) >= 6);
    }

}