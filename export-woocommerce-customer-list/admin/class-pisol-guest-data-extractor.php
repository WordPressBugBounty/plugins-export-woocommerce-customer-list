<?php

class class_guest_data_extractor{

    public $after_date;
    public $before_date;
    public $order_status;
    public $limit;
    public $offset;

    function __construct($after, $before, $order_status = array(), $limit = 40, $offset = 0){
        $this->after_date = $after;
        $this->before_date = $before;
        $this->order_status = $order_status;

        $this->limit = $limit;
        $this->offset = $offset;
    }

    function getOrders(){
        $args = array(
            'limit' => $this->limit,
            'customer_id'=> 0,
            'offset'=>$this->offset
        );

        if(empty($this->before_date)){
            $this->before_date = date('Y-m-d', strtotime('+1 days', current_time('timestamp')));
        }

        if($this->after_date != "" && $this->before_date !=""){
            $time_range = $this->after_date.'...'.$this->before_date;
            $args['date_created'] = $time_range;
        }elseif($this->after_date == "" && $this->before_date !=""){
            $time_range = '<'.$this->before_date;
            $args['date_created'] = $time_range;
        }elseif($this->after_date != "" && $this->before_date ==""){
            $time_range = '>'.$this->after_date;
            $args['date_created'] = $time_range;
        }

        if(count($this->order_status) > 0){
            $args['status'] = $this->order_status;
        }
        
        $orders = wc_get_orders($args);
        return $orders;
        
    }

    function getRows(){
        $orders = $this->getOrders();
        $rows = array();
        foreach($orders as $order){
            $row = $this->getRow($order);
            $rows[] = $row;
        }
        return $rows;
    }

    function getRow($order){
        $row = array(
            $order->get_id(),
            $order->get_billing_email(),
            $order->get_billing_phone(),
            $order->get_billing_first_name(),
            $order->get_billing_last_name(),
            $order->get_billing_address_1(),
            $order->get_billing_address_2(),
            $order->get_billing_city(),
            $order->get_billing_state(),
            $order->get_billing_postcode(),
            $order->get_billing_country(),
            $order->get_shipping_first_name(),
            $order->get_shipping_last_name(),
            $order->get_shipping_address_1(),
            $order->get_shipping_address_2(),
            $order->get_shipping_city(),
            $order->get_shipping_state(),
            $order->get_shipping_postcode(),
            $order->get_shipping_country()
        );
        return $row;
    }

    function getHeader(){
        $header = array(
            __('Order ID','pisol-ewcl'),
            __('Email','pisol-ewcl'),
            __('Phone','pisol-ewcl'),
            __('Billing First Name','pisol-ewcl'),
            __('Billing Last Name','pisol-ewcl'),
            __('Billing Address 1','pisol-ewcl'),
            __('Billing Address 2','pisol-ewcl'),
            __('Billing City','pisol-ewcl'),
            __('Billing State','pisol-ewcl'),
            __('Billing Post Code','pisol-ewcl'),
            __('Billing Country','pisol-ewcl'),
            __('Shipping First Name','pisol-ewcl'),
            __('Shipping Last Name','pisol-ewcl'),
            __('Shipping Address 1','pisol-ewcl'),
            __('Shipping Address 2','pisol-ewcl'),
            __('Shipping City','pisol-ewcl'),
            __('Shipping State','pisol-ewcl'),
            __('Shipping Post Code','pisol-ewcl'),
            __('Shipping Country','pisol-ewcl'),
        );

        return $header;
    }

    

}