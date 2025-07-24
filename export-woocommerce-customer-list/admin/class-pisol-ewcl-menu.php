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
                                <?php //do_action($this->plugin_name.'_tab'); ?>
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
                <div class="bg-light border pl-3 pr-3 pt-0">
                    <div class="pisol-row">
                        <div class="col">
                        <?php do_action($this->plugin_name.'_tab_content'); ?>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 border-left">
                            <div id="pisol-side-menu" class="mb-4 rounded py-4">
                                <?php do_action($this->plugin_name.'_tab'); ?>
                            </div>
                            <?php do_action($this->plugin_name.'_promotion'); ?>
                        </div>
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

            <div class="pi-shadow px-3 py-3 rounded">
                <h2 id="pi-banner-tagline" class="mb-0 mt-3" style="color:#ccc !important;">
                        <span class="d-block mb-4">⭐️⭐️⭐️⭐️⭐️</span>
                        <span class="d-block mb-2">🚀 Trusted by <span style="color:#fff;">3,000+</span> WooCommerce Stores</span>
                        <span class="d-block mb-2">Rated <span style="color:#fff;">4.9/5</span> – Users love it</span>
                </h2>
                <div class="inside">
                    <ul class="pisol-pro-feature-list my-4">
                        <li><span style="color:white;">&#10003;</span> Export guest customer list</li>
                        <li><span style="color:white;">&#10003;</span> Filter by order status</li>
                        <li><span style="color:white;">&#10003;</span> Customize CSV column labels</li>
                        <li><span style="color:white;">&#10003;</span> Download by registration date</li>
                        <li><span style="color:white;">&#10003;</span> Download by date range</li>
                        <li><span style="color:white;">&#10003;</span> Get list via email (Hourly, Daily, etc.)</li>
                        <li><span style="color:white;">&#10003;</span> Email list of recent signups</li>
                        <li><span style="color:white;">&#10003;</span> Export extra user data from other plugins</li>
                        <li><span style="color:white;">&#10003;</span> Choose guest, registered, or both in email</li>
                        <li><span style="color:white;">&#10003;</span> Control download speed</li>
                    </ul>

                    <h4 class="pi-bottom-banner">💰 Just <?php echo esc_html(PI_EWCL_PRICE); ?></h4>
                    <h4 class="pi-bottom-banner">🔥 Unlock all features and grow your sales!</h4>

                    <div class="text-center pb-3 pt-2">
                    <a class="btn btn-primary btn-lg" href="<?php echo esc_url(PI_EWCL_BUY_URL); ?>&utm_ref=bottom_link" target="_blank">🔓 Unlock Pro Now – Limited Time Price!</a>
                    </div>
                </div>
               </div>

               <div class="bg-dark text-light text-center mb-3">
                    <a href="<?php echo esc_url(PI_EWCL_BUY_URL); ?>" target="_blank">
                    <?php  new pisol_promotion("pi_ewcl_installation_date"); ?>
                    </a>
                </div>

            
        <?php
    }

    function isWeekend() {
        return (date('N', strtotime(date('Y/m/d'))) >= 6);
    }

}