<?php

class Class_Pi_Ewcl_Email{

    public $plugin_name;

    private $settings = array();

    private $active_tab;

    private $this_tab = 'email';

    private $tab_name = "Schedule CSV";

    private $setting_key = 'pi_ewcl_email_setting';

    public $tab;

    public $pi_ewcl_enable_email;
    public $email;
    public $subject;
    public $message;
    public $frequency;
    public $cron_event;
    
    

    function __construct($plugin_name){
        $this->plugin_name = $plugin_name;

        add_action('init', array($this,'init'));
        
        $this->tab = sanitize_text_field(filter_input( INPUT_GET, 'tab'));
        $this->active_tab = $this->tab != "" ? $this->tab : 'default';

        if($this->this_tab == $this->active_tab){
            add_action($this->plugin_name.'_tab_content', array($this,'tab_content'));
        }

        add_action($this->plugin_name.'_tab', array($this,'tab'),3);

        if(PI_EWCL_DELETE_SETTING){
            $this->delete_settings();
        }

        $this->pi_ewcl_enable_email = get_option('pi_ewcl_enable_email',0);
        $this->email = get_option('pi_ewcl_email');
        $this->subject = get_option('pi_ewcl_email_subject');
        $this->message = get_option('pi_ewcl_email_message');
        $this->frequency = 'twicedaily';

        add_filter( 'cron_schedules', array($this, 'cron_add_weekly') );

        $this->cron_event = 'pi_ewcl_customer_email';

        if($this->pi_ewcl_enable_email == 1 && $this->email != ""){
            add_action( $this->cron_event , array($this, 'sendEmail') );
            if ( ! wp_next_scheduled( $this->cron_event ) ) {
                wp_schedule_event( time(), $this->frequency, $this->cron_event );
            }
            $set_frequency = wp_get_schedule($this->cron_event);
            if($set_frequency != $this->frequency){
                wp_clear_scheduled_hook($this->cron_event);
                wp_schedule_event( time(), $this->frequency, $this->cron_event );
            }
        }
    }

    function init(){
        $this->tab_name = __("Schedule CSV",'pisol-ewcl');

        $this->settings = array(
            
            array('field'=>'title', 'class'=> 'bg-dark opacity-75 text-light', 'class_title'=>'text-light font-weight-light h4', 'label'=>__('Automatically send customer list csv','pisol-ewcl'), 'type'=>"setting_category"),

            array('field'=>'pi_ewcl_enable_email', 'label'=>__('Send customer list in email','pisol-ewcl'),'type'=>'switch', 'default'=> 0,   'desc'=>__('You can schedule when to receive the emails','pisol-ewcl')),
            
            array('field'=>'pi_ewcl_email', 'label'=>__('Email ID','pisol-ewcl'),'type'=>'text',   'desc'=>__('Email address that will receive the CSV attachment. You can add more than one email address separated with commas.','pisol-ewcl')),

            array('field'=>'pi_ewcl_email_subject', 'label'=>__('Email subject','pisol-ewcl'),'type'=>'text',   'desc'=>__('Subject of the email','pisol-ewcl'), 'pro'=>true),

            array('field'=>'pi_ewcl_email_message', 'label'=>__('Email message','pisol-ewcl'),'type'=>'text',   'desc'=>__('Message of the email','pisol-ewcl'), 'pro'=>true),

            array('field'=>'pi_ewcl_email_frequency', 'label'=>__('Email frequency','pisol-ewcl'),'type'=>'select',   'desc'=>__('Email should be sent hourly, daily, weekly, or twice daily','pisol-ewcl'), 'value'=>array('hourly'=>__('Hourly','pisol-ewcl'), 'daily'=>__('Daily','pisol-ewcl'),'twicedaily'=>__('Twice Daily','pisol-ewcl'), 'weekly'=>__('Weekly','pisol-ewcl')), 'default'=>'twicedaily', 'pro'=>true),

            array('field'=>'pi_ewcl_include_report', 'label'=>__('Include customers','pisol-ewcl'),'type'=>'select',   'desc'=>__('Include Registered customer CSV, Guest customer CSV, or both in the report','pisol-ewcl'), 'value'=>array('registered'=>__('Send only registered customer details','pisol-ewcl'), 'guest'=>__('Send only guest customer details','pisol-ewcl'), 'both'=>__('Send registered and guest customer details','pisol-ewcl')), 'default'=>'registered', 'pro'=>true),
            
        );

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
            <span class="dashicons dashicons-email-alt2"></span> <?php echo esc_html__( $this->tab_name); ?> 
        </a>
        <?php
    }

    function tab_content(){
        ?>
        <form method="post" action="options.php"  class="pisol-setting-form">
        <?php settings_fields( $this->setting_key ); ?>
        
        <?php
            foreach($this->settings as $setting){
                new pisol_class_form_ewcl($setting, $this->setting_key);
            }
        ?>
    <div class="alert alert-danger mt-2">
    FREE version will send the customer list by email twice daily. In the PRO version you can change the frequency to <strong>Daily, Weekly, Hourly</strong>. The email will contain users registered during the selected time period.<br>
    <strong>Free version will not</strong> send guest customer records by email.
    </div>
        <input type="submit" class="my-3 btn btn-primary btn-md" value="Save Option" />
        </form>
       <?php
    }

    function save(){
        $saved_fields = get_option('pi_customer_row',array()) ;
        $saved_fields = is_array($saved_fields) ? $saved_fields : array();

        $fields = class_fields::selectedFields($saved_fields);
        
        $before = $this->before(true);
        $after = $this->after(true);

        //error_log('after:'.$after);
        //error_log('before:'.$before);

        $data_obj = new class_customer_data_extractor($fields, 0, 0,  $after, $before);
        $rows = $data_obj->getRows();
        $header = $data_obj->getHeader();
        $delimiter = ",";
        $filename_initial = "customer_initial";
        
        $csv_file_obj = new class_pisol_ewcl_csv_maker($header, $rows, $delimiter, $filename_initial);

        $file = $csv_file_obj->save();
        return $file;
    }    

    function sendEmail(){
        $file = $this->save();
        $email = $this->email;
        $subject = "Customer list CSV"; 
        $message = file_get_contents(plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/email_template.html'); 

       $email_obj = new class_pisol_ewcl_email($email, $subject, $message, $file);
       $email_obj->send();
    }

    function after($without_gmt = false){  
        $next_run = wp_next_scheduled($this->cron_event);
        $frequency = 'twicedaily';
        $value = '-2 day';
        if($next_run){
           

            if($frequency == 'twicedaily'){
                $value = '-24 hours';
            }

            if($without_gmt){
                /**
                 * without GMT is needed for the registered customer data as registered customer time is saved in universal time format
                 */
                $next_run = date( 'Y-m-d H:i:s', $next_run );
            }else{
                $next_run = get_date_from_gmt( date( 'Y-m-d H:i:s', $next_run ), 'Y-m-d H:i:s' );
            }
            return date('Y-m-d H:i:s', strtotime($value, strtotime($next_run)));
        }
        return "";
    }

    function before($without_gmt = false){  
        $next_run = wp_next_scheduled($this->cron_event);
        $frequency = 'twicedaily';
        $value = '-1 day';
        if($next_run){
            
            if($frequency == 'twicedaily'){
                $value = '-12 hours';
            }

            if($without_gmt){
                /**
                 * without GMT is needed for the registered customer data as registered customer time is saved in universal time format
                 */
                $next_run = date( 'Y-m-d H:i:s', $next_run );
            }else{
                $next_run = get_date_from_gmt( date( 'Y-m-d H:i:s', $next_run ), 'Y-m-d H:i:s' );
            }
            return date('Y-m-d H:i:s', strtotime($value, strtotime($next_run)));
        }
        return "";
    }
    
    function cron_add_weekly( $schedules ) {
        // Adds once weekly to the existing schedules.
        $schedules['weekly'] = array(
            'interval' => 604800,
            'display' => __( 'Once Weekly', 'pisol-ewcl' )
        );
        return $schedules;
     }
    
}

new Class_Pi_Ewcl_Email($this->plugin_name);