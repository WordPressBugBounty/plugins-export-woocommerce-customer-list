<?php

class Class_Pi_Ewcl_Guest{

    public $plugin_name;

    private $settings = array();

    private $active_tab;

    private $this_tab = 'guest';

    private $tab_name = "Guest customer list";

    private $setting_key = 'pi_ewcl_guest_setting';
    
    public $tab;

    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;
        $this->tab_name = __("Guest customer list",'pisol-ewcl');
        $this->settings = array(
            
            array('field'=>'pi_guest_row')
            
        );
        
        $this->tab = sanitize_text_field(filter_input( INPUT_GET, 'tab'));
        $this->active_tab = $this->tab != "" ? $this->tab : 'default';

        if($this->this_tab == $this->active_tab){
            add_action($this->plugin_name.'_tab_content', array($this,'tab_content'));
        }


        add_action($this->plugin_name.'_tab', array($this,'tab'),2);

       
        $this->register_settings();
    }

    
    function delete_settings(){
        foreach($this->settings as $setting){
            delete_option( $setting['field'] );
        }
    }

    function register_settings(){   

        foreach($this->settings as $setting){
            register_setting( $this->setting_key, $setting['field']);
        }
    
    }

    function tab(){
        $page = sanitize_text_field(filter_input( INPUT_GET, 'page'));
        ?>
        <a class=" px-3 text-light d-flex align-items-center  border-left border-right  <?php echo esc_attr($this->active_tab == $this->this_tab ? 'bg-primary' : 'bg-secondary'); ?>" href="<?php echo esc_url(admin_url( 'admin.php?page='.$page.'&tab='.$this->this_tab )); ?>">
            <?php echo esc_html( $this->tab_name); ?> 
        </a>
        <?php
    }

    function tab_content(){
        $customer_rows = get_option('pi_guest_row',array());
        $page = sanitize_text_field(filter_input( INPUT_GET, 'page'));
       ?>
       <form id="ewcl-download-guest-record" action="<?php echo esc_url(admin_url( 'admin.php?page='.$page.'&tab='.$this->this_tab.'&pi_action=download_guest_list')); ?>" method="POST">

       <div id="row_title" class="row py-4 border-bottom align-items-center bg-primary text-light">
            <div class="col-12">
            <h2 class="mt-0 mb-0 text-light font-weight-light h4"><?php echo esc_html__('Download Guest Customer', 'pisol-ewcl'); ?></h2>
            </div>
        </div>
        <div id="row_title" class="row py-4 border-bottom">
            <div class="col-12">
            <div class="alert alert-primary">
                <?php echo esc_html__('Guest customer list will not be affected by the field saved in the "field in CSV" tab, "Field in CSV" tab only works on the CSV of registered customer', 'pisol-ewcl'); ?>
            </div>
            </div>
        </div>
        <div id="row_pi_ewcl_delimiter" class="row py-4 border-bottom align-items-center ">
            <div class="col-12 col-md-5">
            <label class="h6 mb-0" for="pi_ewcl_delimiter"><?php echo esc_html__('Delimiters', 'pisol-ewcl'); ?></label>            <br><small><?php echo esc_html__('How value are separated in csv', 'pisol-ewcl'); ?></small>            </div>
            <div class="col-12 col-md-7">
                <select class="form-control" name="pi_ewcl_delimiter" id="pi_ewcl_delimiter">
                    <option value=",">,</option>
                    <option value=";">;</option>
                </select>           
            </div>
        </div>
        <div id="row_pi_ewcl_order_status " class="row py-4 border-bottom align-items-center free-version">
            <div class="col-12 col-md-5">
            <label class="h6 mb-0" for="pi_ewcl_order_status"><?php echo esc_html__('Guest customer based on order status', 'pisol-ewcl'); ?></label>            <br><small><?php echo esc_html__('Download guest customer based on the order status, use control to select multiple status, if left empty all guest will be selected', 'pisol-ewcl'); ?></small>            </div>
            <div class="col-12 col-md-7">
                <select class="form-control" name="pi_ewcl_order_status" id="pi_ewcl_order_status" multiple>
                    <option value='pending' selected>Pending</option>
                    <option value="processing">Processing</option>
                    <option value="on-hold">On-Hold</option>
                    <option value="completed" selected>Completed</option>
                    <option value="refunded">Refunded</option>
                    <option value="failed">Failed</option>
                    <option value="cancelled">Cancelled</option>
                </select>           
            </div>
        </div>
        <div id="row_pi_ewcl_download_offset" class="row py-4 border-bottom align-items-center ">
            <div class="col-12 col-md-5">
            <label class="h6 mb-0" for="pi_ewcl_download_offset"><?php echo esc_html__('Gust checkout done between', 'pisol-ewcl'); ?></label>            <br><small><?php echo esc_html__('select the date range, If you leave this date empty it will download all the guest users in your website', 'pisol-ewcl'); ?></small>           
            </div>
            <div class="col-12 col-md-3">
            <div>
            <label for="pi_ewcl_download_after_date"><?php echo esc_html__('Start Date', 'pisol-ewcl'); ?></label>
            <input type="text" readonly class="form-control datepicker" name="pi_ewcl_download_after_date" id="pi_ewcl_download_after_date" placeholder="<?php echo esc_html__('From this date', 'pisol-ewcl'); ?>">
            </div>
            <a href="javascript:void()" class="pi-clear-date"><?php echo esc_html__('Clear', 'pisol-ewcl'); ?></a>
            </div>
            <div class="col-12 col-md-1 text-center">
            <label>&</label>
            </div>
            <div class="col-12 col-md-3">
            <div>
            <label for="pi_ewcl_download_before_date"><?php echo esc_html__('End Date', 'pisol-ewcl'); ?></label>
            <input type="text" readonly class="form-control datepicker" name="pi_ewcl_download_before_date" id="pi_ewcl_download_before_date" placeholder="<?php echo esc_html__('Till this date', 'pisol-ewcl'); ?>">
            </div>
            <a href="javascript:void()" class="pi-clear-date"><?php echo esc_html__('Clear', 'pisol-ewcl'); ?></a>
            </div>
        </div>

        <div id="row_pi_ewcl_limit" class="row py-4 border-bottom align-items-center free-version">
            <div class="col-12 col-md-5">
            <label class="h6 mb-0" for="pi_limit"><?php echo esc_html__('Extraction speed', 'pisol-ewcl'); ?></label><br><small><?php echo esc_html__('You can increase the speed of extraction by increasing this number, but if you are trying to extract a large record on shared hosting having this set to large number can break the extraction process', 'pisol-ewcl'); ?></small>
            </div>
            <div class="col-12 col-md-7">
                <input type="number" name="pi_limit"  id="pi_limit" value="50" class="form-control" step="1" min="10">         
            </div>
        </div>
       
       <div class="text-center pt-5">
        <input type="submit" class="btn btn-primary btn-lg my-2" value="<?php echo esc_html__('Download Guest Customer list', 'pisol-ewcl'); ?>">
        </div>
        <?php wp_nonce_field( 'pisol-ewcl-guest-customer'); ?>
       </form>
       
       <?php
    }
    
    
}
add_action('init',function(){
new Class_Pi_Ewcl_Guest($this->plugin_name);
});