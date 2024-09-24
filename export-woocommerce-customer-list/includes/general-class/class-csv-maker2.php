<?php


class class_pisol_ewcl_csv_maker2{

    static function createFile($initial){
        $file_name = self::fileName($initial);
        return $file_name;
    }

    static function writeToFile($file_name, $header, $rows, $delimiter = ','){
        try
        {
            $full_path = self::fileDirectoryPath($file_name);
            $file_obj = self::createFileObject($full_path);

            if(!empty($header) && is_array($header)){
                self::writeHeader( $file_obj, $header, $delimiter );
            }

            if(!empty($rows) && is_array($rows)){
                self::writeData( $file_obj, $rows, $delimiter );
            }

            fclose($file_obj);
        } catch ( Exception $e ) {
            return $e->getMessage();
        } 

        return true;
    }

    static function writeHeader($file_obj, $header, $delimiter = ','){
        $header = array_map( array( __CLASS__, 'stop_csv_injection' ), $header );
        fputcsv($file_obj, $header, $delimiter);
    }

    static function writeData($file_obj, $rows, $delimiter = ','){
        foreach($rows as $row){
            //for($i = 0; $i <= 2000; $i++){ // this is to test if there are large number of data
                $row = array_map( array( __CLASS__, 'stop_csv_injection' ), $row );
                fputcsv($file_obj, $row, $delimiter);
            //}
        }
    }

    static function stop_csv_injection( $value ) {
		$formula_chars = array( "=", "+", "-", "@", "|", "%" );
		if ( in_array( substr( $value, 0, 1 ), $formula_chars ) ) {
			$value = "\" " . $value."\"";
		}

		return $value;
	}

    static function fileName($initial){
        $type = 'csv';
        $file_name_initial = $initial;
        $file_name = $file_name_initial.'_'.time().".".$type;
        return $file_name;
    }
    /**
     * return php://output OR Wordpress upload directory 
     * combined with csv file name and initial
     */
    static function fileDirectoryPath($file_name){
       
            $upload_dir   = wp_upload_dir();
            $directory =  $upload_dir['basedir'].'/ewcl_customers';
            $directory_path = $upload_dir['basedir'].'/ewcl_customers/'.$file_name;
            if(is_dir($directory)){
                chmod($directory, 0755);
                return $directory_path;
            }else{
                self::create_folder();

                if(is_dir($directory)){
                    return $directory_path;
                }

                return $upload_dir['basedir'].'/'.$file_name;
            }
        
    }



    /**
     * file object is returned
     */
    static function createFileObject($directory){
        $file_obj = fopen( $directory,"a+");
        return $file_obj;
    }

    static function create_folder() {
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

    static function triggerDownload( $file_name ){
        header('Content-Type: text/csv; charset=UTF-8');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="'.$file_name.'";');
        header('Pragma: no-cache');
        // make php send the generated csv lines to the browser
        $upload_dir   = wp_upload_dir();
        $directory =  $upload_dir['basedir'].'/ewcl_customers';
        $directory_path = $upload_dir['basedir'].'/ewcl_customers/'.$file_name;
        readfile($directory_path);
        exit();
    }
}
