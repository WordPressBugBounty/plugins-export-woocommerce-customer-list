<?php
/**
 * Input: $header -> CSV header
 * $row -> CSV row array
 * $delimiter -> CSV delimiter
 * $filename_initial -> It is used to generate file name 
 * 
 * Two interface:
 * download() -> this will trigger download of the CSV file
 * save() -> this will save the file on the server and return the path of the file saved
 */
class class_pisol_ewcl_csv_maker{

    private $rows = array();
    private $header = array();
    private $delimiter = ",";
    private $filename_initial;
    private $file_name; 
    private $file_obj;
    private $directory_path;
    

    function __construct($header, $rows, $delimiter, $filename_initial ){
        $this->header = $header;
        $this->rows = $rows;
        $this->delimiter = $delimiter;
        $this->filename_initial = $filename_initial;
        $this->file_name = $this->fileName();
    }

    /**
     * This download the generated file
     */
    public function download(){
        $directory = $this->fileDirectoryPath(true);
        $this->file_obj = $this->createFileObject($directory);
        $this->writeHeader();
        $this->writeData();
        $this->triggerDownload();
    }

    /**
     * Save the generated file in uploads folder
     */
    public function save(){
        $directory = $this->fileDirectoryPath(true);
        $this->file_obj = $this->createFileObject($directory); 
        $this->writeHeader();
        $this->writeData();
        return $this->directory_path;
    }

    /**
     * return php://output OR Wordpress upload directory 
     * combined with csv file name and initial
     */
    private function fileDirectoryPath($save_to_upload = false){
        if($save_to_upload){

            $upload_dir   = wp_upload_dir();
            $directory =  $upload_dir['basedir'].'/ewcl_customers';
            $this->directory_path = $upload_dir['basedir'].'/ewcl_customers/'.$this->file_name;

            if(is_dir($directory)){
                chmod($directory, 0755);
                return $this->directory_path;
            }else{
                $this->create_folder();

                if(is_dir($directory)){
                    return $this->directory_path;
                }
                return $upload_dir['basedir'].'/'.$this->file_name;
            }

            
        }else{
            $this->directory_path = 'php://output';
            return $this->directory_path;
        }
    }

    /**
     * file name based in initial provided
     */
    private function fileName($type = 'csv'){
        $file_name_initial = $this->filename_initial;
        if(!isset($this->file_name)){
            $this->file_name = $file_name_initial.'_'.time().".".$type;
        }
        return $this->file_name;
    }

    /**
     * file object is returned
     */
    private function createFileObject($directory){
        $this->file_obj = fopen( $directory,"w");
        return $this->file_obj;
    }


    private function writeHeader(){
        $this->header = array_map( array( __CLASS__, 'stop_csv_injection' ), $this->header );
        fputcsv($this->file_obj, $this->header, $this->delimiter);
    }

    private function writeData(){
        foreach($this->rows as $row){
            $row = array_map( array( __CLASS__, 'stop_csv_injection' ), $row );
            fputcsv($this->file_obj, $row, $this->delimiter);
        }
    }

    static function stop_csv_injection( $value ) {
		$formula_chars = array( "=", "+", "-", "@", "|", "%" );
		if ( in_array( substr( $value, 0, 1 ), $formula_chars ) ) {
			$value = "\" " . $value."\"";
		}

		return $value;
	}

    private function triggerDownload(){
        header('Content-Type: text/csv; charset=UTF-8');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="'.$this->file_name.'";');
        header('Pragma: no-cache');
        // make php send the generated csv lines to the browser
        readfile($this->directory_path);
        /*
        fpassthru($this->file_obj);
        fclose($this->file_obj);
        */
        exit();
    }

    private function create_folder() {
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