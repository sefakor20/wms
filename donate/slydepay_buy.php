<?php
session_start();
require_once('./includes/iwallet/lib/iwallet/IwalletConnector.class.php');
require_once('./includes/iwallet/UUID.inc.php');
require_once('./includes/rb.php');

    $dbConfig = parse_ini_file('./config/db.properties', true);
    $payLIVE = parse_ini_file('./config/payLIVE.properties', true);



//--------connect to database-------------//

$dbUser =$dbConfig['db']['username'];
$dbpass =$dbConfig['db']['password'];
$dbHost=$dbConfig['db']['host'];
$dbName=$dbConfig['db']['dbname'];
$dbPort=$dbConfig['db']['dbport'];

R::setup("mysql:host=$dbHost;dbname=$dbName;port=$dbPort",
        $dbUser,$dbpass);



//---------------------------------------//

//select databse object/table

$donation = R::dispense("donation");

$genOrderId =  uuid();

if($_REQUEST['donationCurrency']=='dollar')
    $donationAmount=($_REQUEST['donationAmount']*$payLIVE['iwalletAPI']['usdRate']);
else
$donationAmount=$_REQUEST['donationAmount'];


//package order details

$donor=$_REQUEST['sponsorName']."(".$_REQUEST['sponsorEmail']."/".$_REQUEST['sponsorMobile'].")";

    


$total = $donationAmount;
$subTotal = $donationAmount;
$shippingCost = 0.00;
$taxAmount = 0.00;
$orderId = $genOrderId;
$comment1 = $payLIVE['orderDetails']['comment1'];

//item details

$itemCode = $payLIVE['orderDetails']['itemCode'];
$itemName = $payLIVE['orderDetails']['itemName'];
$uprice =$donationAmount;
$qty= 1;
$unitSubTotal= $donationAmount;


$pay = new IwalletConnector($payLIVE['iwalletAPI']['ns'], $payLIVE['iwalletAPI']['servUri'], $payLIVE['iwalletAPI']['apiVersion'],
                            $payLIVE['iwalletAPI']['merchantEmail'], $payLIVE['iwalletAPI']['merchantKey'], 
                            $payLIVE['iwalletAPI']['serviceType'], $payLIVE['iwalletAPI']['intMode']);


$order_items = array();
$order_items[0] = $pay->buildOrderItem($itemCode, $itemName, $uprice, $qty, $unitSubTotal);
//  $order_items[0] = $iwl->buildOrderItem($item_code, $item_name, $unit_price, $quantity, $sub_total)

 $result = $pay->MobilePaymentOrder($orderId, $subTotal, $shippingCost, $taxAmount, $total, $comment1, $donor, $order_items);


//echo '<pre>';
//var_dump($result);
//echo '<pre>';


if($result->mobilePaymentOrderResult->success == "true") {//Token returned

	//redirect to i-walletlive order page
	$pay_token = $result->mobilePaymentOrderResult->token;
        
        

	$url = $payLIVE['iwalletAPI']['payUri'];
	
	//Only "pay_token" required here but additional params may be added. These params will be returned to the merchant site with the callback
	$url .= '?pay_token='.$result->mobilePaymentOrderResult->token;
        
            $donation->trnx_id=$genOrderId;
            $donation->amount=$_REQUEST['donationAmount'];
            $donation->currency= $_REQUEST['donationCurrency']   ;
            $donation->mobile=$_REQUEST['sponsorMobile'];
            $donation->email=$_REQUEST['sponsorEmail'];
            $donation->show_name=$_REQUEST['sponsorShowName'];
            $donation->pay_token= $pay_token;
            $donation->status="PENDING";
            $donation->trnx_date=R::isoDateTime();

            try {
            $id=R::store($donation);

            R::close();
            
                } catch (Exception $e) {
                //     redirect('index.php?status=2');
                    echo "error saving donation";


                         exit();
            
        }
	
	//$pay->redirect($url); 
        echo $url;
} else {
	//Custom error handling should go here
	echo "Error Processing Request: ".$result->mobilePaymentOrderResult->error;
}