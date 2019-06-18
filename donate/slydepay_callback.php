<?php

/*
 * Receive postback from iwalletlive and confirm transaction
 *
 */
session_start();

require_once('./includes/iwallet/lib/iwallet/IwalletConnector.class.php');
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

//get response params from iwalletlive (payment_order_transaction)
$pay_token = stripslashes(trim($_REQUEST['pay_token']));
$transac_id = stripslashes(trim($_REQUEST['transac_id']));
$status = stripslashes(trim($_REQUEST['status']));
$order_id = stripslashes(trim($_REQUEST['cust_ref']));

switch ($status) {
    case "0":  //for success
        //confirm trasactions. money only available to merchant AFTER transaction has been confirmed
       $pay = new IwalletConnector($payLIVE['iwalletAPI']['ns'], $payLIVE['iwalletAPI']['servUri'], $payLIVE['iwalletAPI']['apiVersion'],
                            $payLIVE['iwalletAPI']['merchantEmail'], $payLIVE['iwalletAPI']['merchantKey'], 
                            $payLIVE['iwalletAPI']['serviceType'], $payLIVE['iwalletAPI']['intMode']);

        $confirm = $pay->ConfirmTransaction($pay_token, $transac_id);
        
        
   
        switch ($confirm->ConfirmTransactionResult) {
            case "1": //success
                $donation  = R::findOne("donation", "pay_token='$pay_token'");
                $donation->status="COMPLETED";
                $donation->date_completed=R::isoDateTime();
                $donation->iwallet_trnx_id=$transac_id;
                       
                        try {
                        $id=R::store($donation);

                        R::close();

                        } catch (Exception $e) {
                             redirect('success.html');

                           exit();

                }
                
               // echo "Transaction Completed";
                redirect('success.html');
                break;
            case "-1": //error pay_token
                //echo "Invalid pay token";
                redirect('success.html');
                break;
            case "0": //error transac_id
               // echo "Invalid transaction id";
                redirect('success.html');
                break;
            default: //error unknown
                //echo "unknown error";
                redirect('success.html');
               
                break;
        }

        break;
    case "-1": //handle for technical error
        //echo "technical error";
        redirect('error.html');
        break;
    case "-2":  //handle for user cancelled error
         redirect('cancelled.html');
        break;
    default:
        redirect('error.html');
       // echo "unknown error";
        break;
}


function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}