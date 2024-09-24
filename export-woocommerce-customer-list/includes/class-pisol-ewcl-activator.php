<?php

class Pisol_Ewcl_Activator {


	public static function activate() {
		add_option('pi_ewcl_do_activation_redirect', true);
		self::create_folder();
	}

	/**
	 * This function creates a download folder this folder is download 
	 * protected, all the plugin files will go in this folder
	 */
	public static function create_folder() {
		$upload_dir      = wp_upload_dir();

		$files = array(
			array(
				'base'    => $upload_dir['basedir'] . '/ewcl_customers',
				'file'    => 'index.html',
				'content' => '',
			),
			array(
				'base'    => $upload_dir['basedir'] . '/ewcl_customers',
				'file'    => '.htaccess',
				'content' => 'deny from all',
			)
		);

		foreach ( $files as $file ) {
			if ( wp_mkdir_p( $file['base'] ) && ! file_exists( trailingslashit( $file['base'] ) . $file['file'] ) ) {
				$file_handle = @fopen( trailingslashit( $file['base'] ) . $file['file'], 'w' ); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.file_system_read_fopen
				if ( $file_handle ) {
					fwrite( $file_handle, $file['content'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fwrite
					fclose( $file_handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
				}
			}
		}
		chmod($files[0]['base'], 0755);
	}

}
