<?php

    require_once('./includes/iwallet/lib/nuSoap/nusoap.php');
    $payLIVE = parse_ini_file('./config/payLIVE.properties', true);
    
class iwalletLIVE_Service {
    var $config, $proxy, $port, $pusername, $ppassword, $request, $response, $servUri, $soapHeader;

    function iwalletLIVE_Service() {
        global $payLIVE;
        $this->config = $payLIVE;
        $this->proxy = $payLIVE['Network']['proxyHost'];
        $this->port = $payLIVE['Network']['proxyPort'];
        $this->pusername = $payLIVE['Network']['username'];
        $this->ppassword = $payLIVE['Network']['password'];

        $this->servUri = $payLIVE['Merchant']['servUri'];

        $this->soapHeader = "<PaymentHeader xmlns=\"http://www.i-walletlive.com/payLIVE\">
                                <APIVersion>".$payLIVE['Merchant']['apiVersion']."</APIVersion>
                                <MerchantKey>".$payLIVE['Merchant']['merchantKey']."</MerchantKey>
                                <MerchantEmail>".$payLIVE['Merchant']['merchantEmail']."</MerchantEmail>
                                <SvcType>C2B</SvcType>
                                <UseIntMode>".$payLIVE['Merchant']['intMode']."</UseIntMode>
                            </PaymentHeader>";
    }

    function setServUri($processor){
        $this->servUri = $this->config[$processor]['servUri'];
    }

    /**************************************************************************
    ** name: getServUrl()
    ** created by: Michael
    ** description: gets iwalletlive payment service url
    ** parameters:
    ** returns: string url
    ***************************************************************************/
    function getServUri($processor=null) {
        if($processor!=null)
            return $this->config[$processor]['servUri'];
        else
            return $this->config['Merchant']['servUri'];
    }

    /**************************************************************************
    ** name: getPayUrl()
    ** created by: Michael
    ** description: gets iwalletlive payLIVE merchant order payment page url
    ** parameters:
    ** returns: string url
    ***************************************************************************/
    function getPayUri($processor=null) {
        if($processor!=null)
            return $this->config[$processor]['payUri'];
        else
            return $this->config['Merchant']['payUri'];
    }

    function setPayHeader($processor) {
        $this->soapHeader = "<PaymentHeader xmlns=\"http://www.i-walletlive.com/payLIVE\">
                                <APIVersion>".$this->config[$processor]['apiVersion']."</APIVersion>
                                <MerchantKey>".$this->config[$processor]['merchantKey']."</MerchantKey>
                                <MerchantEmail>".$this->config[$processor]['merchantEmail']."</MerchantEmail>
                                <SvcType>C2B</SvcType>
                                <UseIntMode>".$this->config[$processor]['intMode']."</UseIntMode>
                            </PaymentHeader>";
    }

    /**************************************************************************
    ** name: processOrder()
    ** created by: Michael
    ** description: Process a transaction with iwalletlive
    ** parameters: $params we're processing here
    ** returns:
    ***************************************************************************/
    function processOrder($params, $processor=null) {
        if($processor!=null){
            $this->setServUri($processor);
            $this->setPayHeader($processor);
        }

        // Create the client instance
        $client = new nusoap_client($this->servUri, true);

        // Set the SOAP method headers
        $client->setHeaders($this->soapHeader);

        //Set the SOAP method proxies
        $client->setHTTPProxy($this->proxy, $this->port, $this->pusername, $this->ppassword);

        $err = $client->getError();
        if($err) {
            //echo '<h2>Constructor error</h2><pre>'.$err.'</pre>';
            throw new Exception('<h2>Constructor error</h2><pre>' . $err . '</pre>');
        }
        // Call the SOAP method
        $result = $client->call('ProcessOrder', $params);

        //Place debug info here
        $this->request = $client->request;
        $this->response = $client->response;

        if($client->fault) {
            //return $result;
            throw new Exception('<h2>Fault [Send Message](Expect - The request contains an invalid SOAP body)</h2>' . $result . '<pre>', 1);
        } else {
            $err=$client->getError();
            if($err) {
                //return $err;
                throw new Exception('<h2>Error [Send Message]:</h2><pre>' . $err . '</pre>', 2);
            } else {
                return $result['ProcessOrderResult'];
            }
        }
    }

    /**************************************************************************
    ** name: processOrderTransaction()
    ** created by: Michael
    ** description: Process a transaction with iwalletlive
    ** parameters: $params we're processing here
    ** returns:
    ***************************************************************************/
    function processOrderTransaction($params, $processor=null) {
        if($processor!=null){
            $this->setServUri($processor);
            $this->setPayHeader($processor);
        }

        // Create the client instance
        $client = new nusoap_client($this->servUri, true);

        // Set the SOAP method headers
        $client->setHeaders($this->soapHeader);

        //Set the SOAP method proxies
        $client->setHTTPProxy($this->proxy, $this->port, $this->pusername, $this->ppassword);

        $err = $client->getError();
        if($err) {
            //echo '<h2>Constructor error</h2><pre>'.$err.'</pre>';
            throw new Exception('<h2>Constructor error</h2><pre>' . $err . '</pre>');
        }
        // Call the SOAP method
        $result = $client->call('ProcessPaymentOrder', $params);

        //Place debug info here
        $this->request = $client->request;
        
        echo $this->request; 
        exit();
        $this->response = $client->response;

        if($client->fault) {
            //return $result;
            throw new Exception('<h2>Fault [Send Message](Expect - The request contains an invalid SOAP body)</h2>' . $result . '<pre>', 1);
        } else {
            $err=$client->getError();
            if($err) {
                //return $err;
                throw new Exception('<h2>Error [Send Message]:</h2><pre>' . $err . '</pre>', 2);
            } else {
                return $result['ProcessPaymentOrderResult'];
            }
        }
    }

    /**************************************************************************
    ** name: confirm_transaction()
    ** created by: Michael
    ** description: Process a transaction with iwalletlive
    ** parameters: $pay_token, $transac_id
    ** returns:
    ***************************************************************************/
    function confirmTransaction($pay_token, $transac_id, $processor=null) {
        if($processor!=null){
            $this->setServUri($processor);
            $this->setPayHeader($processor);
        }

        // Create the client instance
        $client = new nusoap_client($this->servUri, true);

        // Set the SOAP method headers
        $client->setHeaders($this->soapHeader);

        //Set the SOAP method proxies
        $client->setHTTPProxy($this->proxy, $this->port, $this->pusername, $this->ppassword);

        $err = $client->getError();
        if($err) {
            //echo '<h2>Constructor error</h2><pre>'.$err.'</pre>';
            throw new Exception('<h2>Constructor error</h2><pre>' . $err . '</pre>');
        }
        // Call the SOAP method
        $result = $client->call('ConfirmTransaction', array('payToken' => $pay_token,
                'transactionId' => $transac_id
        ));

        //Place debug info here
        $this->request = $client->request;
        $this->response = $client->response;

        if($client->fault) {
            //return $result;
            throw new Exception('<h2>Fault [Send Message](Expect - The request contains an invalid SOAP body)</h2>' . $result . '<pre>', 1);
        } else {
            $err=$client->getError();
            if($err) {
                //return $err;
                throw new Exception('<h2>Error [Send Message]:</h2><pre>' . $err . '</pre>', 2);
            } else {
                return $result['ConfirmTransactionResult'];
            }
        }
    }

    /**************************************************************************
    ** name: authenticate_user()
    ** created by: Michael
    ** description: Authenticate an iwalletlive user
    ** parameters: $usernme, $password
    ** returns: boolean
    ***************************************************************************/
    function authenticateUser($username, $password, $processor=null) {
        if($processor!=null){
            $this->setServUri($processor);
            $this->setPayHeader($processor);
        }

        // Create the client instance
        $client = new nusoap_client($this->servUri, true);

        //Set the SOAP method proxies
        $client->setHTTPProxy($this->proxy, $this->port, $this->pusername, $this->ppassword);

        $err = $client->getError();
        if($err) {
            //echo '<h2>Constructor error</h2><pre>'.$err.'</pre>';
            throw new Exception('<h2>Constructor error</h2><pre>' . $err . '</pre>');
        }
        // Call the SOAP method
        $result = $client->call('Authenticate', array('username' => $username,
                'password' => $password
        ));

        //Place debug info here
        $this->request = $client->request;
        $this->response = $client->response;

        if($client->fault) {
            //return $result;
            throw new Exception('<h2>Fault [Send Message](Expect - The request contains an invalid SOAP body)</h2>' . $result . '<pre>', 1);
        } else {
            $err=$client->getError();
            if($err) {
                //return $err;
                throw new Exception('<h2>Error [Send Message]:</h2><pre>' . $err . '</pre>', 2);
            } else {
                return $result['AuthenticateResult'];
            }
        }
    }

    //helper functions
    function redirect($to) {
        $hs = headers_sent();
        if($hs == false) {
            header("Location: $to");
            header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        } else if($hs == true) {
            echo "<script>document.location.href='$to';</script>\n";
        }
    }
}

