<?php

class Class_Pi_Ewcl_Option{

    public $plugin_name;

    private $settings = array();

    private $active_tab;

    private $this_tab = 'default';

    private $tab_name = "Registered Customer list";

    private $setting_key = 'pi_ewcl_basic_setting';

    public $tab;
    

    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;
        $this->tab_name = __("Download Registered Customers" , 'pisol-ewcl');

        $this->settings = array(
            
            array('field'=>'pi_customer_row')
            
        );
        
        $this->tab = sanitize_text_field(filter_input( INPUT_GET, 'tab'));
        $this->active_tab = $this->tab != "" ? $this->tab : 'default';

        if($this->this_tab == $this->active_tab){
            add_action($this->plugin_name.'_tab_content', array($this,'tab_content'));
        }


        add_action($this->plugin_name.'_tab', array($this,'tab'),1);

       
        $this->register_settings();

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
           <span class="dashicons dashicons-admin-users"></span> <?php echo esc_html($this->tab_name); ?> 
        </a>
        <?php
    }

    function get_roles() {
        global $wp_roles;
    
        $all_roles = $wp_roles->roles;
    
        return  $all_roles;
    }

    function tab_content(){
        $customer_rows = get_option('pi_customer_row',array());
        $roles = $this->get_roles();
        $page = sanitize_text_field(filter_input( INPUT_GET, 'page'));
       ?>
       <form id="ewcl-download-registered-record" action="<?php echo esc_url(admin_url( 'admin.php?page='.$page.'&pi_action=download_customer_list')); ?>" method="POST">
       <div id="row_title" class="row py-4 border-bottom align-items-center bg-dark opacity-75 text-light">
            <div class="col-12">
            <h2 class="mt-0 mb-0 text-light font-weight-light h4"><?php echo esc_html__('Download registered customers', 'pisol-ewcl'); ?></h2>
            </div>
        </div>
        <div id="row_pi_ewcl_download_limit" class="row py-4 border-bottom align-items-center ">
            <div class="col-12 col-md-5">
            <label class="h6 mb-0" for="pi_ewcl_download_limit"><?php echo esc_html__('Number of rows to extract', 'pisol-ewcl'); ?></label>            <br><small><?php echo wp_kses_post(__('Specify number of rows to extract<br>0 means all rows will be extracted<br>This should be a multiple of 6', 'pisol-ewcl')); ?></small>            </div>
            <div class="col-12 col-md-7">
            <input type="number" class="form-control " name="pi_ewcl_download_limit" id="pi_ewcl_download_limit" value="0" min="0" step="6" placeholder="should be multiple of 6">            </div>
        </div>
        <div id="row_pi_ewcl_download_offset" class="row py-4 border-bottom align-items-center ">
            <div class="col-12 col-md-5">
            <label class="h6 mb-0" for="pi_ewcl_download_offset"><?php echo esc_html__('Number of rows to skip', 'pisol-ewcl'); ?></label>            <br><small><?php echo esc_html__('Specify number of rows to skip from the top', 'pisol-ewcl'); ?></small>            </div>
            <div class="col-12 col-md-7">
            <input type="number" class="form-control " name="pi_ewcl_download_offset" id="pi_ewcl_download_offset" value="0" min="0" step="1">            </div>
        </div>
        <div id="row_pi_ewcl_limit" class="row py-4 border-bottom align-items-center free-version">
            <div class="col-12 col-md-5">
            <label class="h6 mb-0" for="pi_limit"><?php echo esc_html__('Extraction speed', 'pisol-ewcl'); ?></label><br><small><?php echo esc_html__('You can increase the speed of extraction by increasing this number, but if you are trying to extract a large record on shared hosting having this set to a large number can break the extraction process', 'pisol-ewcl'); ?></small>
            </div>
            <div class="col-12 col-md-7">
                <input type="number" name="pi_limit"  id="pi_limit" value="60" class="form-control" step="1" min="10">         
            </div>
        </div>
        <div id="row_pi_ewcl_download_offset" class="row py-4 border-bottom align-items-center free-version">
            <div class="col-12 col-md-5">
            <label class="h6 mb-0" for="pi_ewcl_download_offset"><?php echo esc_html__('Delimiters', 'pisol-ewcl'); ?></label>            <br><small><?php echo esc_html__('How values are separated in CSV', 'pisol-ewcl'); ?></small>            </div>
            <div class="col-12 col-md-7">
                <select class="form-control" name="pi_ewcl_delimiter" id="pi_ewcl_delimiter">
                    <option value=",">,</option>
                    <option value=";">;</option>
                </select>           
            </div>
        </div>
        <div id="row_pi_ewcl_user_role" class="row py-4 border-bottom align-items-center free-version">
            <div class="col-12 col-md-5">
            <label class="h6 mb-0" for="pi_ewcl_user_role"><?php echo esc_html__('Select the user role to download (If you leave this blank it will download WooCommerce Customer)', 'pisol-ewcl'); ?></label>            <br><small><?php echo esc_html__('If you want to download users with a different role then select it from the dropdown. To download WooCommerce customers either select "Customer" or leave the selection empty', 'pisol-ewcl'); ?></small>            </div>
            <div class="col-12 col-md-7">
                <select class="form-control" name="pi_ewcl_user_role[]" id="pi_ewcl_user_role" multiple>
                <?php foreach($roles as $key => $role){ ?>
                    <option value='<?php echo esc_attr($key); ?>' 
                    <?php if($key == 'customer' || $key == 'administrator'){ echo 'selected="selected"'; } ?>
                    >
                    <?php echo esc_html($role['name']); ?></option>
                <?php } ?>
                </select>           
            </div>
        </div>
        <div id="row_pi_ewcl_download_offset" class="row py-4 border-bottom align-items-center free-version">
            <div class="col-12 col-md-5">
            <label class="h6 mb-0" for="pi_ewcl_download_offset"><?php echo esc_html__('Registration done between', 'pisol-ewcl'); ?></label>            <br><small><?php echo esc_html__('Extract users whose registration was done between these date ranges', 'pisol-ewcl'); ?></small>            </div>
            <div class="col-12 col-md-3">
            <input type="text" readonly class="form-control datepicker" name="pi_ewcl_download_after_date" id="pi_ewcl_download_after_date" placeholder="<?php echo esc_html__('After date', 'pisol-ewcl'); ?>">
            </div>
            <div class="col-12 col-md-1 text-center">
            <label>&</label>
            </div>
            <div class="col-12 col-md-3">
            <input type="text" readonly class="form-control datepicker" name="pi_ewcl_download_before_date" id="pi_ewcl_download_before_date" placeholder="<?php echo esc_html__('Before date', 'pisol-ewcl'); ?>">
            </div>
        </div>
       <div class="text-center pt-5">
        <input type="submit" class="btn btn-primary btn-lg my-2" value="<?php echo esc_html__('Download Registered Customer List', 'pisol-ewcl'); ?>">
        </div>
        <?php wp_nonce_field( 'pisol-ewcl-registered-customer'); ?>
       </form>
       
       <?php
    }
    
    
}
add_action('init',function(){
    new Class_Pi_Ewcl_Option($this->plugin_name);
});