<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include_once 'IwalletConnector.class.php';
        
        
            $paylive="http://192.168.0.22:8083/payLIVE/detailsnew.aspx?pay_token=";
            $ns="http://www.i-walletlive.com/payLIVE"; 
            $wsdl="http://192.168.0.22:8083/paylive/paymentservice.asmx?wsdl";
//            $paylive="http://stage.i-walletlive.com/dotnetnuke_test/payLIVE/detailsnew.aspx?pay_token=";
//            $ns="http://www.i-walletlive.com/payLIVE"; 
//            $wsdl="http://stage.i-walletlive.com/dotnetnuke_test/paylive/paymentservice.asmx?wsdl";
            
            
            $api_version="1.4";
            $merchant_email="iwallet@dreamoval.com"; 
            $merchant_secret_key="bdVI+jtRl80PG4x6NMvYOwfZTZtwfN"; 
//            $merchant_email="yoofi@mytxtbuddy.com"; 
//            $merchant_secret_key="tEsQ+BfwbokfSUQD9o7kHLilRr522T"; 
            
            
            $service_type="C2B"; 
            $integration_mode=true;
            
            $iwl = new IwalletConnector($ns, $wsdl, $api_version, $merchant_email, $merchant_secret_key, $service_type, $integration_mode);
            
            $order_id=92;
            $sub_total=100;
            $shipping_cost=30;
            $tax_amount=0;
            $total=130;
            $comment1="something";
            $comment2="";
            $order_items = array();
            $order_items[0] = $iwl->buildOrderItem("001", "organza", 50, 2, 100);
//            $order_items[0] = $iwl->buildOrderItem($item_code, $item_name, $unit_price, $quantity, $sub_total)
            
            $response = $iwl->MobilePaymentOrder($order_id, $sub_total, $shipping_cost, $tax_amount, $total, $comment1, $comment2, $order_items);
            
            var_dump($response->mobilePaymentOrderResult);
            $redirect = $paylive.$response->mobilePaymentOrderResult->token;
            var_dump($redirect);
            header("Location: $redirect");
            
            
        ?>
    </body>
</html>
