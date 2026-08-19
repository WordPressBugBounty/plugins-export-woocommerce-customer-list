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
		wp_enqueue_style( $this->plugin_name.'_promotion', plugin_dir_url( __FILE__ ) . 'css/promotion.css', array(), $this->version, 'all' );
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
                                    <a href="https://www.piwebsolution.com/" target="_blank"><img class="img-fluid ml-2" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/pi-web-solution.svg"></a>
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
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 border-left">
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
        $this->support();
    }

    function promotion(){
        if(isset($_GET['tab']) && $_GET['tab'] == 'other_plugins') return;
        ?>

            <div class="pisol-ewcl-side-banner">
            <div class="pisol-ewcl-header">
                <div class="pisol-ewcl-badge">PRO</div>
                <div class="pisol-ewcl-stars">★★★★★</div>
            </div>

            <h3 class="pisol-ewcl-title">Trusted by 3,000+ Stores</h3>
            <p class="pisol-ewcl-subtitle">Rated 4.9/5 – Users love it</p>

            <ul class="pisol-ewcl-features">
                <li>Export guest customer list</li>
                <li>Filter by order status</li>
                <li>Customize CSV column labels</li>
                <li>Download by registration date</li>
                <li>Download by date range</li>
                <li>Get list via email (Hourly, Daily, etc.)</li>
                <li>Email list of recent signups</li>
                <li>Export extra user data from other plugins</li>
                <li>Choose guest, registered, or both in email</li>
                <li>Control download speed</li>
            </ul>

            <div style="text-align: center;">
                <div class="peq-ticket">
                    <span class="peq-ticket-amount"><?php echo esc_html(PI_EWCL_PRICE); ?></span>
                    <span class="peq-ticket-word">only</span>
                </div>
            </div>

            <a href="<?php echo esc_url(PI_EWCL_BUY_URL); ?>" target="_blank" class="pisol-ewcl-btn">
                <span>Unlock Pro Now</span>
                <small>Limited Time Price</small>
            </a>
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

    function support(){
        $website_url = home_url();
        $plugin_name = $this->plugin_name;
        ?>
        <form action="https://www.piwebsolution.com/quick-support/" method="post" target="_blank" style="display:inline; position:fixed; bottom:30px; right:35px; z-index:9999;" >
            <input type="hidden" name="website_url" value="<?php echo esc_attr( $website_url ); ?>">
            <input type="hidden" name="plugin_name" value="<?php echo esc_attr( $plugin_name ); ?>">
            <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;">
                <img src="<?php echo esc_url( plugin_dir_url( __FILE__ ) ); ?>img/chat.png" 
                    alt="Live Support" title="Quick Support" style="width:60px;height:60px;">
            </button>
        </form>
        <?php
    }

}