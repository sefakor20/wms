<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IwalletConnector
 *
 * @author joseph
 */
class IwalletConnector {

    private $iwl;

    function __construct($ns, $wsdl, $api_version, $merchant_email, $merchant_secret_key, $service_type, $integration_mode) {
        $proxySettings = array(
//            "cache_wsdl" => WSDL_CACHE_NONE,
//            "soap_version" => SOAP_1_1,
   //         "trace" => 1,
  //          "proxy_host" => "localhost",
    //        "proxy_port" => 8888,
          );
        libxml_disable_entity_loader(false);

        $this->iwl = new SoapClient($wsdl, $proxySettings);
        $this->buildHeader($ns, $api_version, $merchant_email, $merchant_secret_key, $service_type, $integration_mode);
    }

    function buildHeader($ns, $api_version, $merchant_email, $merchant_secret_key, $service_type, $integration_mode) {
        $iwalletHeaders = array(
            "APIVersion" => $api_version,
            "MerchantEmail" => $merchant_email,
            "MerchantKey" => $merchant_secret_key,
            "SvcType" => $service_type,
            "UseIntMode" => $integration_mode
        );

        $headers = new SoapHeader($ns, "PaymentHeader", $iwalletHeaders);

        $this->iwl->__setSoapHeaders($headers);
    }

    function ConfirmTransaction($pay_token, $transaction_id) {

        try {

            $params = array(
                'payToken' => $pay_token,
                'transactionId' => $transaction_id,
            );
            $return = $this->iwl->ConfirmTransaction($params);
            return $return;
        } catch (Exception $e) {
            echo "Exception occured: " . $e;
        }
    }

    function CancelTransaction($pay_token, $transaction_id) {

        try {

            $params = array(
                'payToken' => $pay_token,
                'transactionId' => $transaction_id,
            );
            $return = $this->iwl->CancelTransaction($params);
            return $return;
        } catch (Exception $e) {
            echo "Exception occured: " . $e;
        }
    }

    function ProcessOrder($amount, $cust_ref, $comment1, $comment2, $unit_price, $quantity, $item, $use_token, $use_int_mode) {

        try {

            $params = array(
                'amount' => $amount,
                'custRef' => $cust_ref,
                'comment1' => $comment1,
                'comment2' => $comment2,
                'unitPrice' => $unit_price,
                'quantity' => $quantity,
                'item' => $item,
                'useToken' => $use_token,
                'useIntMode' => $use_int_mode,
            );
            $return = $this->iwl->ProcessOrder($params);
            return $return;
        } catch (Exception $e) {
            echo "Exception occured: " . $e;
        }
    }

    function ProcessPaymentJSON($order_id, $amount, $comment1, $comment2, array $order_items) {
        try {

            $params = array(
                'orderId' => $order_id,
                'amount' => $amount,
                'comment1' => $comment1,
                'comment2' => $comment2,
                'orderItems' => $order_items,
            );
            $return = $this->iwl->ProcessPaymentJSON($params);
            return $return;
        } catch (Exception $e) {
            echo "Exception occured: " . $e;
        }
    }

    function CheckPaymentStatus($order_id, $provider_name, $provider_type) {


        try {
            $wsdl_url = 'https://www.i-walletlive.com/paylive/paymentservice.asmx?wsdl';
            $client = new SOAPClient($wsdl_url);
            $params = array(
                'orderId' => $order_id,
                'providerName' => $provider_name,
                'providerType' => $provider_type,
            );
            $return = $this->iwl->checkPaymentStatus($params);
            return $return;
        } catch (Exception $e) {
            echo "Exception occured: " . $e;
        }
    }

    function ProcessPaymentOrder($order_id, $sub_total, $shipping_cost, $tax_amount, $total, $comment1, $comment2, array $order_items) {

        try {

            $params = array(
                'orderId' => $order_id,
                'subtotal' => $sub_total,
                'shippingCost' => $shipping_cost,
                'taxAmount' => $tax_amount,
                'total' => $total,
                'comment1' => $comment1,
                'comment2' => $comment2,
                'orderItems' => $order_items,
            );
            $return = $this->iwl->ProcessPaymentOrder($params);
            return $return;
        } catch (Exception $e) {
            echo "Exception occured: " . $e;
        }
    }

    function GeneratePaymentCode($order_id, $sub_total, $shipping_cost, $tax_amount, $total, $comment1, $comment2, Array $order_items, $payer_name, $payer_mobile, $provider_name, $provider_type) {

        try {

            $params = array(
                'orderId' => $order_id,
                'subtotal' => $sub_total,
                'shippingCost' => $shipping_cost,
                'taxAmount' => $tax_amount,
                'total' => $total,
                'comment1' => $comment1,
                'comment2' => $comment2,
                'orderItems' => $order_items,
                'payerName' => $payer_name,
                'payerMobile' => $payer_mobile,
                'providerName' => $provider_name,
                'providerType' => $provider_type,
            );
            $return = $this->iwl->generatePaymentCode($params);
            return $return;
        } catch (Exception $e) {
            echo "Exception occured: " . $e;
        }
    }

    function MobilePaymentOrder($order_id, $sub_total, $shipping_cost, $tax_amount, $total, $comment1, $comment2, Array $order_items) {

        try {

            $params = array(
                'orderId' => $order_id,
                'subtotal' => $sub_total,
                'shippingCost' => $shipping_cost,
                'taxAmount' => $tax_amount,
                'total' => $total,
                'comment1' => $comment1,
                'comment2' => $comment2,
                'orderItems' => $order_items,
            );
            $return = $this->iwl->mobilePaymentOrder($params);
            return $return;
//            print_r($return);
        } catch (Exception $e) {
            echo "Exception occured: " . $e;
        }
    }

    function VerifyMobilePayment($order_id) {


        try {
              $params = array(
                'orderId' => $order_id,
            );
            $return = $this->iwl->verifyMobilePayment($params);
            return $return;
        } catch (Exception $e) {
            echo "Exception occured: " . $e;
        }
    }

    function buildOrderItem($item_code, $item_name, $unit_price, $quantity, $sub_total) {
        $order = new stdClass();
        $order->ItemCode = $item_code;
        $order->ItemName = $item_name;
        $order->UnitPrice = $unit_price;
        $order->Quantity = $quantity;
        $order->SubTotal = $sub_total;
        
        return $order;
    }

}
