<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
include('iwalletLIVE_Service.class.php');

try {
    $iwallet = new iwalletLIVE_Service();
    //echo $iwallet->authenticateUser('testpaddy', 'paddypaddy');
    var_dump($iwallet->servUri);
} catch(Exeception $e) {
    echo $e->getMessage();
}
