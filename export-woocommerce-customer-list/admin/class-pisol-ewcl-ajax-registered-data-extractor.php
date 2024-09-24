<?php

class pisol_ewcl_ajax_registered_data_extractor{
    function __construct(){
        add_action('wp_ajax_pisol_ewcl_export_registered_data', array($this, 'exportRegisteredRecord'));
    }

    function exportRegisteredRecord(){

        check_ajax_referer( 'pisol-ewcl-registered-customer' );
        
        if(!current_user_can( 'administrator' )) return;

       
	    //$_REQUEST = $form = (array) $form;

        $step     = absint( sanitize_text_field($_POST['step']) );

        $limit = 4;

        $saved_fields = get_option('pi_customer_row',array()) ;
        $saved_fields = is_array($saved_fields) ? $saved_fields : array();

        $after = "";
        
        $before = "";

        $delimiter =  ",";

        $roles = (isset($_POST['pi_ewcl_user_role']) && is_array($_POST['pi_ewcl_user_role'])) ? sanitize_text_field($_POST['pi_ewcl_user_role']): array('customer');

        $download_limit = empty($_POST['pi_ewcl_download_limit']) || !is_numeric($_POST['pi_ewcl_download_limit']) ? 0 : sanitize_text_field($_POST['pi_ewcl_download_limit']);

        $skip_rows = empty($_POST['pi_ewcl_download_offset']) || !is_numeric($_POST['pi_ewcl_download_offset']) ? 0 : sanitize_text_field($_POST['pi_ewcl_download_offset']);

        $row_extracted = empty($_POST['row_extracted']) || !is_numeric($_POST['row_extracted']) ? 0 : sanitize_text_field($_POST['row_extracted']);

    
        $step = $step === 0 || $step === '0' ? $skip_rows : $step;

        if(!empty($before) && !empty($after) && strtotime($after) > strtotime($before)){
            $data = array(
                'error'=> "Start date cant be after End date",
            );
            wp_send_json($data,400);
        }


        $fields = class_fields::selectedFields($saved_fields);
        
        $data_obj = new class_customer_data_extractor($fields, $limit, $step, $after, $before);

        $rows = $data_obj->getRows();
        $header = '';

        $row_extracted = count($rows) + $row_extracted;

        if(empty($_POST['file_name'])){
            
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

}
new pisol_ewcl_ajax_registered_data_extractor();