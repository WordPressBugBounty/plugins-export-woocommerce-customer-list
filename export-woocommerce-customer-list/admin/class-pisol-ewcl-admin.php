<?php

class Pisol_Ewcl_Admin {

	
	private $plugin_name;

	
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		new Pi_Ewcl_Menu($this->plugin_name, $this->version);

		add_action('admin_init', array($this,'plugin_redirect'));

		add_action( 'wp', array($this,'scheduleCleaningEvent') );
		add_action('pisol_ewcl_clear_old_files', array($this,'clearCsvFolder'));
	}

	function plugin_redirect(){
		if (get_option('pi_ewcl_do_activation_redirect', false)) {
			delete_option('pi_ewcl_do_activation_redirect');
			if(!isset($_GET['activate-multi']))
			{
				wp_redirect('admin.php?page=pisol-ewcl-notification');
			}
		}
	}

	function scheduleCleaningEvent() {
		if ( ! wp_next_scheduled( 'pisol_ewcl_clear_old_files' ) ) {
			wp_schedule_event( time(), 'daily', 'pisol_ewcl_clear_old_files');
		}
	}

	function clearCsvFolder(){
		if(is_ajax() || !empty($_GET['pisol_download_file'])) return;
		$upload_dir   = wp_upload_dir();
        $directory =  $upload_dir['basedir'].'/ewcl_customers/';
		$files = glob($directory.'*.csv'); //get all file names
		foreach($files as $file){
			if(is_file($file))
			unlink($file); //delete file
		}
	}

	
	public function enqueue_styles() {
		

	}

	
	public function enqueue_scripts() {

		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pisol-ewcl-admin.js', array( 'jquery' ), $this->version, false );

		if(!empty($_GET['tab']) && $_GET['tab'] == 'guest' && !empty($_GET['page']) && $_GET['page'] == 'pisol-ewcl-notification'){
			wp_enqueue_script( $this->plugin_name.'-guest-ajax-exporter', plugin_dir_url( __FILE__ ) . 'js/pisol-guest-ajax-exporter.js', array( 'jquery' ), $this->version, false );
		}

		if((empty($_GET['tab']) || $_GET['tab'] == 'default') && !empty($_GET['page']) && $_GET['page'] == 'pisol-ewcl-notification'){
			wp_enqueue_script( $this->plugin_name.'-registered-ajax-exporter', plugin_dir_url( __FILE__ ) . 'js/pisol-registered-ajax-exporter.js', array( 'jquery' ), $this->version, false );
		}

	}

}
