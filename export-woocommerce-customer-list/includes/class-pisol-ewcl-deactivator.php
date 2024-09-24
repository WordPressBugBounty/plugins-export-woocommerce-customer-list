<?php

class Pisol_Ewcl_Deactivator {

	public static function deactivate() {
		/**
		 * this will clean the csv folder on deactivation of the plugin 
		 */
		do_action('pisol_ewcl_clear_old_files');
	}

}
