<?php

class pisol_ewcl_ajax_guest_data_extractor{
    function __construct(){
        add_action('wp_ajax_pisol_ewcl_export_guest_data', array($this, 'exportGuestRecord'));

        add_action('wp_loaded', array($this, 'download'));
    }

    function exportGuestRecord(){

        check_ajax_referer( 'pisol-ewcl-guest-customer' );

        if(!current_user_can( 'administrator' )) return;

	    //$_REQUEST = $form = (array) $form;

        $step     = absint(sanitize_text_field( $_POST['step'] ));

        $limit = 2;

        $download_limit = 0; // we want to limit it to 30 so we are allowing 4*8 = 32

        $delimiter = isset($_POST['pi_ewcl_delimiter']) ? sanitize_text_field($_POST['pi_ewcl_delimiter']) : ",";

        $after = isset($_POST['pi_ewcl_download_after_date']) ? sanitize_text_field($_POST['pi_ewcl_download_after_date']): "";
        
        $before = isset($_POST['pi_ewcl_download_before_date']) ? sanitize_text_field($_POST['pi_ewcl_download_before_date']) : "";

        $row_extracted = empty($_POST['row_extracted']) || !is_numeric($_POST['row_extracted']) ? 0 : sanitize_text_field($_POST['row_extracted']);

        if(!empty($before) && !empty($after) && strtotime($after) > strtotime($before)){
            $data = array(
                'error'=> "Start date cant be after End date",
            );
            wp_send_json($data,400);
        }


        $data_obj = new class_guest_data_extractor($after, $before,array(), $limit, $step );

        $rows = $data_obj->getRows();
        $header = '';

        $row_extracted = count($rows) + $row_extracted;

        if($step == 0 && empty($_POST['file_name'])){
            
            $filename_initial = "customer_initial";

            $file_name = class_pisol_ewcl_csv_maker2::createFile($filename_initial);

            $header = $data_obj->getHeader();
        }else{
            $file_name = sanitize_file_name($_POST['file_name']);
        }

        $write_result = class_pisol_ewcl_csv_maker2::writeToFile($file_name, $header, $rows, $delimiter);
        
        if(empty($rows)){
            $step = 'done';
        }else{
            $step = $limit + $step;
        }

        if(!empty( $download_limit) && $row_extracted >= $download_limit ){
            $step = 'done';
        }

        $url = isset($_POST['_wp_http_referer']) ? sanitize_url( $_POST['_wp_http_referer']) : '';

        $download_url = add_query_arg('pisol_download_file', $file_name, $url);

        $data = array(
            'step'=>$step ,
            'file_name'=> $file_name,
            'download_url' => $download_url,
            'row_extracted' => $row_extracted
        );

        if($write_result !== true){
            $data = array(
                'error'=> $write_result,
            );
            wp_send_json($data,400);
        }

        wp_send_json($data);
	    
    }

    function download(){
        if(!empty($_GET['pisol_download_file']) && current_user_can( 'administrator' )){
            $file_name = sanitize_file_name( $_GET['pisol_download_file'] );
            class_pisol_ewcl_csv_maker2::triggerDownload($file_name);
        }
    }
}
new pisol_ewcl_ajax_guest_data_extractor();